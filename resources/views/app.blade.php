<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello laravel & Vue</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/core.css?id=958c6f876b2d1acbc4d4114547d5ae20') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/css/theme-default.css?id=c1176873cc66093bc08d573f549565f3') }}">
    <link rel="stylesheet" href="{{ url('assets/css/demo.css?id=69dfc5e48fce5a4ff55ff7b593cdf93d') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font_lao.css') }}">

    @vite('resources/css/app.css')
</head>
<body>

    <div id="app-vue"> </div>

    <script src="{{ url('assets/vendor/libs/jquery/jquery.js?id=fbe6a96815d9e8795a3b5ea1d0f39782') }}"></script>
    <script src="{{ url('assets/vendor/libs/popper/popper.js?id=bd2c3acedf00f48d6ee99997ba90f1d8') }}"></script>
    <script src="{{ url('assets/vendor/js/bootstrap.js?id=43cd2f28b83d6ba5a95e1b78ed109e43') }}"></script>
    <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js?id=f4192eb35ed7bdba94dcb820a77d9e47') }}"></script>

    @vite('resources/js/app.js')
</body>
</html>