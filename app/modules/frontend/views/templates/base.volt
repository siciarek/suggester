<!DOCTYPE html>
<html lang="{{ this.di.getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ app_name }}</title>

    {% block stylesheets %}
        <link href="/themes/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/themes/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/themes/bootstrap/css/bootstrap-adjustments.css" rel="stylesheet"/>
        <link href="/themes/bootstrap/css/font-awesome.min.css" rel="stylesheet"/>
        <style>
            div.wait {
                background-image: url(/images/spinner.gif);
                background-repeat: no-repeat;
                background-position: center;
                background-color: rgba(255, 255, 255, 0.5);
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 64000;
            }
        </style>
    {% endblock %}
</head>

<body>

<div class="container">
    {% block content %}{% endblock %}
</div>

<div class="wait hidden"></div>

{% block javascripts %}
    <script src="/themes/bootstrap/js/jquery.min.js"></script>
    <script src="/themes/bootstrap/js/bootstrap.min.js"></script>
    <script src="/themes/bootstrap/js/remember-last-tab.js"></script>
{% endblock %}
</body>
</html>
