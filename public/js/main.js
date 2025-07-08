document.addEventListener('DOMContentLoaded', () => {
    let currentPage = 1;
    let totalPages = 1;
    const userList = document.getElementById('user-list');
    const pagination = document.getElementById('pagination');
    const form = document.querySelector('#register-form form');
    const modal = document.getElementById('register-modal');

    function showUserModal(userId) {
        fetch(`/api/v1/users/${userId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const modal = document.getElementById('user-modal');
                    const content = modal.querySelector('.user-modal-content');
                    const u = data.user;

                    content.innerHTML = `
                        <h3>${u.name}</h3>
                        <img src="${u.photo}" alt="photo" style="max-width:100px; max-height:100px;"><br>
                        <strong>Email:</strong> ${u.email}<br>
                        <strong>Phone:</strong> ${u.phone}<br>
                        <strong>Position:</strong> ${u.position}<br>
                    `;

                    modal.style.display = 'flex';
                } else {
                    showGlassModal(data.message || 'User not found');
                }
            });
    }

    function loadUsers(page = 1) {
        fetch(`/api/v1/users?page=${page}&count=6`)
            .then(res => res.json())
            .then(data => {
                userList.innerHTML = '';
                data.users.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.phone}</td>
                        <td><button class="show-user-btn" data-id="${user.id}">Show</button></td>
                    `;
                    userList.appendChild(row);
                });

                document.querySelectorAll('.show-user-btn').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        const id = btn.getAttribute('data-id');
                        showUserModal(id);
                    });
                });

                totalPages = data.total_pages;
                updatePagination(totalPages, page);
            });
    }

    document.getElementById('close-user-modal').addEventListener('click', () => {
        document.getElementById('user-modal').style.display = 'none';
    });

    function updatePagination(totalPages, currentPage) {
        pagination.innerHTML = '';

        const createPageButton = (label, page, active = false) => {
            const btn = document.createElement('button');
            btn.innerText = label;
            btn.className = 'page-btn';
            if (active) btn.classList.add('active');
            btn.addEventListener('click', () => loadUsers(page));
            return btn;
        };

        if (currentPage > 1) {
            pagination.appendChild(createPageButton('<<', 1));
            pagination.appendChild(createPageButton('<', currentPage - 1));
        }

        let start = Math.max(1, currentPage - 2);
        let end = Math.min(totalPages, currentPage + 2);

        if (start > 1) {
            pagination.appendChild(createPageButton('1', 1));
            if (start > 2) {
                const dots = document.createElement('span');
                dots.innerText = '...';
                dots.className = 'page-dots';
                pagination.appendChild(dots);
            }
        }

        for (let i = start; i <= end; i++) {
            pagination.appendChild(createPageButton(i, i, i === currentPage));
        }

        if (end < totalPages) {
            if (end < totalPages - 1) {
                const dots = document.createElement('span');
                dots.innerText = '...';
                dots.className = 'page-dots';
                pagination.appendChild(dots);
            }
            pagination.appendChild(createPageButton(totalPages, totalPages));
        }

        if (currentPage < totalPages) {
            pagination.appendChild(createPageButton('>', currentPage + 1));
            pagination.appendChild(createPageButton('>>', totalPages));
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        const tokenRes = await fetch('/api/v1/token', { method: 'POST' });
        const tokenData = await tokenRes.json();
        const token = tokenData.token;

        try {
            const res = await fetch('/api/v1/users', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Token': token
                },
                body: formData
            });

            const data = await res.json();

            // clear previous errors
            form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

            if (!res.ok) {
                if (data?.errors) {
                    let msg = 'Validation error:\n';
                    for (let key in data.errors) {
                        const field = form.querySelector(`[name="${key}"]`);
                        if (field) {
                            field.classList.add('error');
                            field.addEventListener('input', function removeError() {
                                field.classList.remove('error');
                                field.removeEventListener('input', removeError);
                            });
                        }
                        msg += `- ${data.errors[key].join(', ')}\n`;
                    }
                    showGlassModal(msg.trim());
                } else {
                    showGlassModal(data.message || 'Unknown error');
                }
                return;
            }

            showGlassModal(data.message || 'Успешно');
            if (data.success) {
                form.reset();
                modal.style.display = 'none';
                loadUsers();
            }
        } catch (err) {
            showGlassModal('Network or server error. Please try again later.');
            console.error(err);
        }
    });


    function showGlassModal(message) {
        let modal = document.createElement('div');
        modal.style.position = 'fixed';
        modal.style.top = '50%';
        modal.style.left = '50%';
        modal.style.transform = 'translate(-50%, -50%)';
        modal.style.background = 'rgba(255, 255, 255, 0.6)';
        modal.style.backdropFilter = 'blur(10px)';
        modal.style.border = '1px solid #a0dccc';
        modal.style.padding = '20px';
        modal.style.borderRadius = '12px';
        modal.style.boxShadow = '0 0 15px rgba(0,0,0,0.2)';
        modal.innerText = message;
        document.body.appendChild(modal);
        setTimeout(() => modal.remove(), 3000);
    }

    document.getElementById('open-register').addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    document.getElementById('close-register').addEventListener('click', () => {
        modal.style.display = 'none';
    });

    loadUsers();
});
