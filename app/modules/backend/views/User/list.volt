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
            {{ dump(users) }}
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