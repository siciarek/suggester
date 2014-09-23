{% extends 'templates/base.volt' %}

{% block content %}

    <div class="alert alert-info">
        <i class="fa fa-check-square-o fa-fw fa-lg"></i>
        {{ 'suggestion.confirmation'|trans }}
    </div>
    <div class="buttons">
        <a href="#" class="btn btn-default btn-lg cancel hidden">{{ 'common.no'|trans }}</a>

        <form method="get" action="{{ url({ 'for' : 'frontend.form'}) }}">
            <input type="hidden" name="application" value="{{ options['application'] }}"/>
            <input type="hidden" name="author" value="{{ options['author'] }}"/>
            <input type="hidden" name="page_url" value="{{ options['page_url'] }}"/>
            <input type="submit" class="btn btn-default btn-lg" value="{{ 'common.yes'|trans }}"/>
        </form>
    </div>

{% endblock %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            var parentWindow = null;
            var frame = null;

            try {
                if (parent.document !== 'undefined') {
                    parentWindow = $(parent.document);
                    frame = parentWindow.find('iframe#__screen');
                }
            }
            catch (e) {

            }

            var btnCancel = $('.btn.cancel');

            if (frame !== null && frame.attr('id') === '__screen') {
                btnCancel.removeClass('hidden');
            }

            btnCancel.click(function (e) {
                e.preventDefault();

                if (frame !== null && frame.attr('id') === '__screen') {
                    frame.attr('src', '{{ url({'for': 'frontend.prompt'}) }}');
                    parentWindow.find('#__suggester_button').trigger('click');
                }
            });

            $('form').on('submit', function(){
                $('div.wait').removeClass('hidden');
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

        form {
            display: inline;
        }
    </style>
{% endblock %}
