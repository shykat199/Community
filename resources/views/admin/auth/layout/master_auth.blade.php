<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{asset("community-frontend/assets/images/community/favicon.png")}}">
    <title>Community</title>
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/odometer-theme-default.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/slick.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/css/default.css")}}">
    <link rel="stylesheet" href="{{asset("community-frontend/assets/sass/style.css")}}">

    <script src="{{asset("community-frontend/assets/js/jquery.min.js")}}"></script>
</head>

<body>

<!-- login page start  -->
@yield('auth.content')
<!-- login page end  -->


<script src="{{asset("community-frontend/assets/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/odometer.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/slick-slider.js")}}"></script>
<script src="{{asset("community-frontend/assets/js/community/script.js")}}"></script>
</body>

</html>
