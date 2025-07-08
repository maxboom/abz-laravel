<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABZ Test App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
            background: #f9fdfc;
            color: #333;
        }
        h1, h2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(6px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        #pagination {
            margin: 10px 0;
            display: flex;
            gap: 6px;
        }
        .page-btn {
            padding: 6px 12px;
            background: #a0dccc;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .page-btn.active {
            background: #5ab7a7;
        }
        .page-btn:hover:not(.active) {
            background: #88c9bb;
        }
        #open-register {
            padding: 10px 18px;
            background: #57c1ad;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease-in-out;
        }
        #open-register:hover {
            background: #4aa697;
        }
        #register-modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        #register-form {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 0 20px rgba(0,0,0,0.25);
            min-width: 300px;
            position: relative;
        }
        #register-form input,
        #register-form select,
        #register-form button[type="submit"],
        #register-form input[type="file"] {
            margin: 8px 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        input.error,
        select.error,
        textarea.error {
            border: 2px solid #e74c3c !important; /* ярко-красный цвет */
            background-color: #fff0f0 !important; /* слегка розовый фон */
            outline: none;
        }
        input,
        select,
        textarea {
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }
        #register-form button[type="submit"] {
            background: #5ab7a7;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        #register-form button[type="submit"]:hover {
            background: #4aa697;
        }
        #close-register {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }
        #close-register:hover {
            color: #000;
        }
        .show-user-btn {
            padding: 6px 12px;
            background: #57c1ad;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s ease-in-out;
        }
        .show-user-btn:hover {
            background: #4aa697;
        }
    </style>
</head>
<body>
<h1>
    Users
    <button id="open-register">Register new User</button>
</h1>
<table>
    <thead>
    <tr>
        <th>Name</th><th>Email</th><th>Phone</th><th></th>
    </tr>
    </thead>
    <tbody id="user-list"></tbody>
</table>
<div id="pagination"></div>

<div id="register-modal">
    <div id="register-form">
        <button id="close-register">&times;</button>
        <h2>Register new user</h2>
        <form enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="tel" name="phone" placeholder="Phone +380..." required><br>

            <select name="position_id" required>
                @foreach(App\Models\Position::all() as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                @endforeach
            </select><br>

            <input type="file" name="photo" accept="image/jpeg" required><br>
            <button type="submit">Register</button>
        </form>
    </div>
</div>

<div id="user-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); justify-content:center; align-items:center; z-index:9999;">
    <div style="background:white; padding:20px; border-radius:10px; max-width:300px; width:100%; position:relative;">
        <button id="close-user-modal" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:20px; cursor:pointer;">&times;</button>
        <div class="user-modal-content"></div>
    </div>
</div>

<script src="/js/main.js"></script>
</body>
</html>
