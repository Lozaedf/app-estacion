<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ APP_NAME }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: {{ COLOR_FONDO_PRINCIPAL }};
            color: {{ COLOR_TEXTO_PRINCIPAL }};
            min-height: 100vh;
        }

        .header {
            background-color: {{ COLOR_HEADER_FONDO }};
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-bottom: 3rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>{{ APP_NAME }}</h1>
            <p>{{ APP_DESCRIPTION }}</p>
        </div>
    </div>