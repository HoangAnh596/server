<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403 - Forbidden</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-size: 100px;
            margin: 0;
            font-weight: 600;
            color: #ff4757;
        }

        h2 {
            font-size: 24px;
            margin: 20px 0;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        a {
            text-decoration: none;
            background-color: #ff4757;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        a:hover {
            background-color: #e84118;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <h2>Forbidden</h2>
        <p>Bạn không có quyền truy cập vào trang này.</p>
        <a href="{{ asset('/admin') }}">Quay về trang chủ Admin</a>
    </div>
</body>
</html>
