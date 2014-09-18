{% extends 'templates/base.volt' %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            $('table.suggestions-table').on('click', '.btn.delete', function (e) {
                e.preventDefault();

                alert('Not implemented yet.');
            });
        });
    </script>
{% endblock %}

{% block content %}
    <h1 class="page-header">
        <i class="fa fa-list-alt text-muted"></i>
        {{ 'suggestion.list'|trans }} ({{ items|length }})
    </h1>

    {% if items|length == 0 %}
        <div class="alert alert-warning">{{ 'common.list_is_empty'|trans }}</div>
    {% else %}
        <table class="table table-condensed table-hover suggestions-table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ 'suggestion.application'|trans }}</th>
                <th>{{ 'common.priority'|trans }}</th>
                <th>{{ 'suggestion.page_url'|trans }}</th>
                <th>{{ 'suggestion.type'|trans }}</th>
                <th>{{ 'suggestion.content'|trans }}</th>
                <th>{{ 'suggestion.author'|trans }}</th>
                <th>{{ 'suggestion.created_at'|trans }}</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            {% for i in items %}
                <tr>
                    <td>{{ i.getId() }}</td>
                    <td>{{ i.getApplication() ? i.getApplication() : '&#0151;' }}</td>
                    <td><span class="badge">{{ i.getPriority() }}</span></td>
                    <td>
                        {% if i.getPageUrl() %}
                        <a href="{{ i.getPageUrl() }}" target="_blank">{{ i.getPageUrl() }}</a></td>
                    {% else %}
                        &#0151;
                    {% endif %}
                    <td>{{ i.getTypeId() }}</td>
                    <td>{{ i.getContent() }}</td>
                    <td>{{ i.getAuthor() ? i.getAuthor() : '&#0151;' }}</td>
                    <td>{{ i.getCreatedAt()|date('Y-m-d H:i') }}</td>
                    <td>
                        <a href="#" title="{{ 'common.remove'|trans }}" class="btn btn-danger btn-xs delete">
                            <i class="fa fa-times-circle fa-fw"></i>
                        </a>
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
