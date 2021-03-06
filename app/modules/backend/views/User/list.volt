{% extends 'templates/base.volt' %}

{% block javascripts %}
{{ super() }}
<script>
    $(document).ready(function(){
       rememberLastTab('nav-tabs');
        $('table.users').on('click', 'i.toggle', function(){
            var self = $(this);
            var id = self.closest('tr').attr('id').replace(/\D*/, '');
            var url = '{{ url({ 'for': 'backend.user.toggle', 'id': 1024 }) }}'.replace(1024, id);

            location.href = url;
        });
    });
</script>
{% endblock %}

{% block stylesheets %}
    {{ super() }}
    <style>
        i.toggle {
            cursor: pointer;
        }
    </style>
{% endblock %}

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
                        <tr id="user-{{ u.getId() }}">
                            <td>
                                <i class="toggle {{ u.getEnabled() ? 'fa-check-square-o' : 'fa-square-o text-muted' }} fa fa-lg"></i>
                            </td>
                            <td>{{ u.getId() }}</td>
                            <td>{{ u.getUsername() }}</td>
                            <td><a href="mailto:{{ u.getEmail() }}">{{ u.getEmail() }}</a></td>
                            <td>{{ u.getFirstName() }}</td>
                            <td>{{ u.getLastName() }}</td>
                            <td>{{ u.getGender()}}</td>
                            <td>{{ u.getCreatedAt()|date('Y-m-d H:i') }}</td>
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
            {% if groups|length == 0 %}
                <div class="alert alert-warning">
                    {{ 'common.list_is_empty'|trans }}
                </div>
            {% else %}
                <table class="table table-hover table-condensed groups">
                    <thead>
                    <tr>
                        <th>{{ 'group.name'|trans }}</th>
                        <th>{{ 'group.description'|trans }}</th>
                        <th>{{ 'group.roles'|trans }}</th>

                        <th>
                            <a href="javascript:void(null)" class="btn btn-success btn-edit btn-xs create">
                                <i class="fa fa-plus fa-lg"></i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for g in groups %}
                        <tr>
                            <td>{{ g['name'] }}</td>
                            <td><em>{{ g['description'] }}</em></td>
                            <td>{{ g['roles'] }}</td>

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
    </div>

    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
        </div>
    </div>

{% endblock %}