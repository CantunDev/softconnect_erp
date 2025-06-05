<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a SoftConnect</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            padding: 40px;
            text-align: center;
        }

        .avatar {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        h1 {
            color: #674299;
            font-size: 28px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #674299;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="avatar" src="https://avatar.oxro.io/avatar.svg?name=Berna" alt="Avatar de {{ $name }}">
        <h1>¡Bienvenido a SoftConnect, {{ $name }}!</h1>
        <p>
            Gracias por registrarte en <strong>SoftConnect</strong>, la herramienta de gestión diseñada especialmente para restaurantes. 
            Ahora puedes comenzar a gestionar tus ventas, controlar gastos y mucho más.
        </p>
        <p>
            Haz clic en el siguiente botón para acceder a tu cuenta:
        </p>
        <a href="{{ url('/') }}" class="button" style="color: #ffffff">Ir a mi cuenta</a>
        
        <div class="footer">
            Si deseas cambiar tu contraseña, puedes hacerlo desde tu perfil en cualquier momento.
        </div>
    </div>
</body>
</html>
