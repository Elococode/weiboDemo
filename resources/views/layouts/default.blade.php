<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','WeiboApp') - Laravel newer!</title>
    <link rel="stylesheet" href="/css/app.css" class="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="/" class="navbar-brand">WeiboApp</a>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item">
                    <a href="/help" class="nav-link">帮助</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">登陆</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>