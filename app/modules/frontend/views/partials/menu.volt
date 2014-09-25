<div class="navbar navbar-default navbar-static-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url({'for':'home'}) }}">
                <i class="fa fa-bullhorn fa-fw fa-lg"></i>
                {{ app_name }} {{ app_version }}
            </a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    {% if user.isAuthenticated() %}
                        <a title="{{ 'user.sign_out'|trans }}" href="{{ url({'for':'user.sign_out'}) }}">
                            <i class="fa fa-unlock-alt fa-fw fa-lg"></i>
                            {{ 'user.sign_out'|trans }}
                        </a>
                    {% else %}
                        <a title="{{ 'user.sign_in'|trans }}" href="{{ url({'for':'user.sign_in'}) }}">
                            <i class="fa fa-unlock-alt fa-fw fa-lg"></i>
                            {{ 'user.sign_in'|trans }}
                        </a>
                    {% endif %}
                </li>
            </ul>
        </div>
    </div>
</div>