<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YSAN Chatbot') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .auth-container {
            max-width: 420px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .auth-header img {
            width: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="auth-container dark:bg-gray-800">
            <div class="auth-header">
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" alt="Aysan Logo">
                <h2 class="text-2xl font-bold text-black-800 dark:text-black-100">
                    YSAN Chatbot
                </h2>
            </div>


            {{ $slot }}
        </div>
    </div>
</body>
</html>
