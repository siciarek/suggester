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

<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{% block brandurl %}/{% endblock %}">
                <i class="fa fa-envelope-o fa-fw fa-lg"></i>
                {{ app_name }} {{ app_version }}
            </a>
        </div>

        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav">
                {% for l in locales %}
                    <li class="{% if l == this.di.getLocale() %}active{% endif %}">
                        <a href="{{ url({'for':'common.locale', 'locale': l}) }}">{{ l|upper }}</a>
                    </li>
                {% endfor %}
            </ul>

            {% block access %}
                <ul class="nav navbar-nav navbar-right">
                    {% if user.isAuthenticated() %}
                        <li>
                            <a href="javascript:void(null)">
                                <i class="fa fa-user fa-fw fa-lg"></i>
                                {{ user.get('firstName') }} {{ user.get('lastName') }} &lt;{{ user.get('email') }}&gt;
                            </a>
                        </li>
                        <li>
                            <a title="{{ 'user.sign_out'|trans }}" href="{{ url({'for':'user.sign_out'}) }}">
                                <i class="fa fa-lock fa-fw fa-lg"></i>
                                {{ 'user.sign_out'|trans }}
                            </a>
                        </li>
                    {% else %}
                        <li>
                            <a title="{{ 'user.sign_in'|trans }}" href="{{ url({'for':'user.sign_in'}) }}">
                                <i class="fa fa-unlock-alt fa-fw fa-lg"></i>
                                {{ 'user.sign_in'|trans }}
                            </a>
                        </li>
                    {% endif %}
                </ul>
            {% endblock %}
        </div>

    </div>
</div>

<div class="container">
    {% block content %}{% endblock %}
</div>

<div class="wait hidden"></div>

{% block javascripts %}
    <script src="/themes/bootstrap/js/jquery.min.js"></script>
    <script src="/themes/bootstrap/js/jquery.cookie.js"></script>
    <script src="/themes/bootstrap/js/bootstrap.min.js"></script>
    <script src="/themes/bootstrap/js/remember-last-tab.js"></script>
{% endblock %}
</body>
</html>
