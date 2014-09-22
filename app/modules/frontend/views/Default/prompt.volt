{% extends 'templates/base.volt' %}

{% block content %}
    <div class="alert alert-success">
        <i class="fa fa-check-square-o fa-fw fa-lg"></i>
        {{ 'suggestion.confirmation'|trans }}
    </div>
    <div class="buttons">
        <a href="#" class="btn btn-default btn-lg cancel hidden">{{ 'common.no'|trans }}</a>

        <form method="get" action="{{ url({ 'for' : 'frontend.form'}) }}" style="display:inline">
            <input type="hidden" name="application" value="{{ options['application'] }}"/>
            <input type="hidden" name="author" value="{{ options['author'] }}"/>
            <input type="submit" class="btn btn-default btn-lg" value="{{ 'common.yes'|trans }}"/>
        </form>
    </div>
{% endblock %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            var parentWindow = $(parent.document);
            var frame = parentWindow.find('iframe#__screen');

            if (frame.attr('id') === '__screen') {
                $('.btn.cancel').removeClass('hidden');
            }

            $('.btn.cancel').click(function (e) {
                e.preventDefault();

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
