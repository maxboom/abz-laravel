# ABZ Agency Test Assignment (Laravel + Blade + JS)

Тестовое задание для ABZ.agency: реализован backend API на Laravel и простой UI-интерфейс на Blade + Vanilla JS.

---

## 🔧 Стек технологий

* Laravel 12
* PHP 8.2
* MySQL / MariaDB
* Blade + JS (Vanilla)
* TinyPNG API
* Laravel Form Request, Seeder, Migration, Storage

## 📦 Установка

```bash
git clone https://github.com/maxboom/abz-laravel
cd abz-laravel
composer install
cp .env.example .env
php artisan key:generate
```

## ⚙️ Настройка

В ```.env``` добавьте настройки БД, JWT секрет и ключ для TinyPNG:
```dotenv
DB_DATABASE=abz
DB_USERNAME=root
DB_PASSWORD=password

TINIFY_KEY=your_tinypng_key_here
JWT_SECRET=your_jwt_key_here
```
Запуск миграций и сидов:
```bash
./sail artisan migrate --seed
```

## 🚀 Запуск
```bash
./sail up -d
```
Открой в браузере: http://127.0.0.1

## 📸 Обработка изображений
- Загружаются .jpg/.jpeg файлы до 5MB
- Оптимизируются и обрезаются до 70x70 через [TinyPNG API](https://tinypng.com/)
- Сохраняются в ```public/uploads/photos/```

## 🔐 Авторизация
- ```POST /api/v1/token``` — получение одноразового токена
- ```POST /api/v1/users``` — регистрация нового пользователя (с токеном в заголовке ```Token```)

## 📄 API endpoints
- ```GET /api/v1/users``` — список пользователей (поддержка ```page```, ```count```)
- ```GET /api/v1/users/{id}``` — конкретный пользователь
- ```POST /api/v1/users``` — регистрация нового пользователя
- ```GET /api/v1/positions``` — список позиций
- ```POST /api/v1/token``` — получить токен для регистрации

## 🧪 UI-интерфейс
- Список пользователей с пагинацией (```<< < 1 2 3 ... > >>```)
- Кнопка “Register new User” открывает модальное окно
- Форма отправляется через JS (fetch), без перезагрузки
- Обработка ошибок на уровне поля (подсветка красным, снятие при вводе)
- Кнопка “Show” в таблице — открывает модалку с полной информацией о пользователе

## ⏱️ Время выполнения
~8 часов (с перерывами), включая валидацию, API, стили и обработку изображений.

## 👤 Автор
Kirill Kramarenko, Kyiv
<br>
Email [zmaxboomz@gmail.com](mailto:zmaxboomz@gmail.com)
<br>
Github: https://github.com/maxboom/abz-laravel
