{% extends 'templates/base.volt' %}

{% block content %}

    <h1 class="page-header">
        <i class="fa fa-list-alt fa-fw text-muted"></i>
        {{ 'user.list'|trans }}
    </h1>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active">
            <a href="#users" role="tab" data-toggle="tab">
                <i class="fa fa-user fa-fw fa-lg"></i>
                {{ 'user.plural_name'|trans }}
            </a>
        </li>
        <li>
            <a href="#groups" role="tab" data-toggle="tab">
                <i class="fa fa-group fa-fw fa-lg"></i>
                {{ 'group.plural_name'|trans }}
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="users">
            {% if users|length == 0 %}
                <div class="alert alert-warning">
                    {{ 'common.list_is_empty'|trans }}
                </div>
            {% else %}
                <table class="table table-hover table-condensed users">
                    <thead>
                    <tr>
                        <th>{{ 'user.enabled'|trans }}</th>
                        <th>{{ 'user.id'|trans }}</th>
                        <th>{{ 'user.username'|trans }}</th>
                        <th>{{ 'user.email'|trans }}</th>
                        <th>{{ 'user.first_name'|trans }}</th>
                        <th>{{ 'user.last_name'|trans }}</th>
                        <th>{{ 'user.gender'|trans }}</th>
                        <th>{{ 'user.created_at'|trans }}</th>


                        <th>
                            <a href="javascript:void(null)" class="btn btn-success btn-edit btn-xs create">
                                <i class="fa fa-plus fa-lg"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for u in users %}
                        <tr>
                            <td><i class="fa {{ u['enabled'] ? 'fa-check-square-o' : 'fa-square-o text-muted' }} fa-lg"></i></td>
                            <td>{{ u['id'] }}</td>
                            <td>{{ u['username'] }}</td>
                            <td><a href="mailto:{{ u['email'] }}">{{ u['email'] }}</a></td>
                            <td>{{ u['first_name'] }}</td>
                            <td>{{ u['last_name'] }}</td>
                            <td>{{ u['gender'] }}</td>
                            <td>{{ u['created_at']|date('Y-m-d H:i') }}</td>


                            <td>
                                <a href="javascript:void(null)" class="btn btn-primary btn-edit btn-xs edit">
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            {% endif %}
        </div>
        <div class="tab-pane" id="groups">
            {{ dump(groups) }}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
        </div>
    </div>

{% endblock %}