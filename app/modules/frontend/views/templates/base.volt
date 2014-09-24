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
            .user-label {
                margin-top: 8px;
                font-weight: bold;
            }

            ul.i18n {
                margin: 0;
                padding: 0;
                display: inline-block;
                list-style-type: none;
                margin-bottom: 12px;
                margin-top: 8px;
            }

            ul.i18n li {
                display: inline-block;
                margin-right: 6px;
            }

            ul.i18n li a {
                text-decoration: none;
                padding: 3px 5px;
            }

            ul.i18n a.active {
                font-weight: bold;
                background-color: #428bca;
                color: white;
            }

            ul.i18n a:hover {

            }

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
    <ul class="i18n">
        <li><i class="fa fa-globe fa-fw fa-lg text-primary"></i></li>
        {% for l in locales %}
            <li>
                <a class="{% if l == this.di.getLocale() %}active{% endif %}"
                   href="{{ url({'for':'common.locale', 'locale': l}) }}">{{ l }}</a>
            </li>
        {% endfor %}
    </ul>
    <div class="user-label text-muted pull-right">
        {% if user.isAuthenticated() %}
            <i class="fa fa-user fa-fw fa-lg"></i>
            {{ user.get('firstName') }} {{ user.get('lastName') }} &lt;{{ user.get('email') }}&gt;

            <a class="text-danger" title="{{ 'user.sign_out'|trans }}" href="{{ url({'for':'user.sign_out'}) }}">
               <span class="fa-stack">
                  <i class="fa fa-square fa-stack-2x"></i>
                  <i class="fa fa-power-off fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        {% else %}
            <a class="text-warning" title="{{ 'user.sign_in'|trans }}" href="{{ url({'for':'user.sign_in'}) }}">
               <span class="fa-stack">
                  <i class="fa fa-square fa-stack-2x"></i>
                  <i class="fa fa-power-off fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        {% endif %}
    </div>

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
