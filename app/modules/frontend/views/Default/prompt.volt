{% extends 'templates/base.volt' %}

{% block content %}
    <div class="alert alert-success">
        <i class="fa fa-check-square-o fa-fw fa-lg"></i>
        {{ 'suggestion.confirmation'|trans }}
    </div>
    <div class="buttons">
            <a id="cancel-button" href="#"
               class="btn btn-default btn-lg">{{ 'common.no'|trans }}</a>
            <a href="{{ url({ 'for' : 'frontend.form'}) }}"
               class="btn btn-default btn-lg">{{ 'common.yes'|trans }}</a>
    </div>
{% endblock %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            $('#cancel-button').click(function (e) {
                e.preventDefault();
                var parentWindow = $(parent.document);
                var frame = parentWindow.find('iframe#__screen');

                if (frame.attr('id') === '__screen') {
                    frame.attr('src', '{{ url({'for': 'frontend.prompt'}) }}');
                    parentWindow.find('#__suggester_button').trigger('click');
                }
            });
        });
    </script>
{% endblock %}

{% block stylesheets %}
    {{ super() }}
    <style>
        .buttons {
            text-align: right;
        }

        body {
            padding: 42px 24px;
            background: #F8F8F8;
        }

        .btn {
            width: 150px;
        }
    </style>
{% endblock %}
