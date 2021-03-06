{% extends 'templates/base.volt' %}

{% block brandurl %}{{ url({'for':'home'}) }}{% endblock %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            $('table.suggestions-table').on('click', '.btn.delete', function (e) {
                e.preventDefault();
                var self = $(this);
                if (confirm('{{ 'suggestion.removal_confirmation'|trans }}')) {
                    $('div.wait').removeClass('hidden');
                    location.href = self.attr('href');
                }
            });
        });
    </script>
{% endblock %}

{% block content %}
    <h1 class="page-header">
        <i class="fa fa-list-alt text-muted"></i>
        {{ 'suggestion.list'|trans }} ({{ items.count() }})
    </h1>

    <div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <a href="{{ url({'for': 'frontend.list_export', 'format': 'csv' }) }}"
               class="btn btn-default btn-lg pull-right{% if items.count() == 0 %} disabled{% endif %}">
                <i class="fa fa-table fa-lg fa=fw text-muted"></i>&nbsp;
                {{ 'common.download_list'|trans }}
            </a>
        </div>
    </div>

    <br/>

    {% if items|length == 0 %}
        <div class="alert alert-info">
            <i class="fa fa-info-circle fa-fw fa-lg"></i>
            {{ 'common.list_is_empty'|trans }}
        </div>
    {% else %}
        <table class="table table-condensed table-hover suggestions-table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ 'suggestion.status'|trans }}</th>
                {% if appscount > 1 %}
                    <th>{{ 'suggestion.application'|trans }}</th>
                {% endif %}
                <th>{{ 'common.priority'|trans }}</th>
                <th>{{ 'suggestion.type'|trans }}</th>
                <th>{{ 'suggestion.content'|trans }}</th>
                <th>{{ 'suggestion.page_url'|trans }}</th>
                <th>{{ 'suggestion.user_agent'|trans }}</th>
                <th>{{ 'suggestion.ip'|trans }}</th>
                <th>{{ 'suggestion.author'|trans }}</th>
                <th>{{ 'suggestion.created_at'|trans }}</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            {% for i in items %}
                <tr>
                    <td>{{ i.getId() }}</td>
                    <td>{{ i.getStatus() }}</td>
                    {% if appscount > 1 %}
                        <td>{{ i.getApplication() ? i.getApplication() : '&#0151;' }}</td>
                    {% endif %}
                    <td><span class="badge">{{ i.getPriority() }}</span></td>
                    <td>{{ ('suggestion.'~type[i.getTypeId()])|trans }}</td>
                    <td><em>{{ i.getContent() }}</em></td>
                    <td>
                        {% if i.getPageUrl() %}
                        <a href="{{ i.getPageUrl() }}" target="_blank">{{ i.getPageUrl() }}</a></td>
                {% else %}
                    &#0151;
                    {% endif %}
                    <td>{{ i.getUserAgent() ? i.getUserAgent() : '&#0151;' }}</td>
                    <td>{{ i.getIp() ? i.getIp() : '&#0151;' }}</td>
                    <td>{{ i.getAuthor() ? i.getAuthor() : 'common.anonymous'|trans }}</td>
                    <td class="nowrap">{{ i.getCreatedAt()|date('Y-m-d H:i') }}</td>
                    <td>
                        {% if is_granted('ROLE_ADMIN') %}
                            <a href="{{ url({'for': 'frontend.remove', 'id': i.getId() }) }}"
                               title="{{ 'common.remove'|trans }}" class="btn btn-danger btn-xs delete">
                                <i class="fa fa-times-circle fa-fw"></i>
                            </a>
                        {% else %}
                            &nbsp;
                        {% endif %}
                    </td>
                </tr>
            {% endfor %}
            </tbody>
        </table>

        {% if items.haveToPaginate() %}
            {{ items.getLayout() }}
        {% endif %}
    {% endif %}

{% endblock %}
