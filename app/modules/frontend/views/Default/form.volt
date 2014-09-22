{% extends 'templates/base.volt' %}

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

            $('#suggestion-form')
                    .on('change', 'select[name=type_id]', function () {
                        if ($(this).val() === '') {
                            $(this).addClass('empty');
                        }
                        else {
                            $(this).removeClass('empty');
                        }
                    })
                    .on('submit', function () {
                        var self = $(this);
                        var button = self.find('*[type=submit]');

                        if (self.find('textarea').val().trim().length > 0) {
                            $('div.wait').removeClass('hidden');
                            button.addClass('disabled');
                        }
                    })
                    .on('click', '*[type=submit]', function (e) {
                        var self = $(this);
                        var form = self.parent();
                        form.find('textarea').val(form.find('textarea').val().trim());
                        form.submit();
                    })
                    .on('click', '.btn.cancel', function (e) {
                        e.preventDefault();

                        if (frame !== null && frame.attr('id') === '__screen') {
                            parentWindow.find('#__suggester_button').trigger('click');
                        }
                    })
                    .find('select[name=type_id]').addClass('empty')
            ;
        });
    </script>
{% endblock %}


{% block stylesheets %}
    {{ super() }}
    <style>
        body {
            padding: 42px 24px;
            background: #F8F8F8;
        }

        .btn {
            width: 150px;
        }

        .btn.cancel {
            margin-right: 12px;
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

{% block content %}
    <div class="alert alert-info">
        <i class="fa fa-edit fa-fw fa-lg"></i>
        {{ 'suggestion.prompt'|trans }}
    </div>

    {{ form(null, 'method': 'post', 'id' : 'suggestion-form', 'class' : 'form-horizontal') }}

    {% for m in form.getMessages() %}
        <div class="alert alert-warning">{{ m.getMessage()|trans }}</div>
    {% endfor %}

    {% for field in [ 'type_id', 'content', 'priority' ] %}
        <div class="input-group">
            {{ form.label(field, { 'class' : 'input-group-addon' }) }}
            {{ form.render(field, { 'class' : 'form-control' }) }}
            {% for m in form.get(field).getMessages() %}
                <div class="error">{{ m.getMessage() }}</div>
            {% endfor %}
        </div>
    {% endfor %}

    {% for field in [ 'csrf', 'page_url', 'author', 'application' ] %}
        {{ form.render(field) }}
    {% endfor %}

    <br/>

    {{ form.render('submit', { 'class': 'btn btn-default btn-lg pull-right' }) }}
    <button type="button" class="btn btn-default btn-lg pull-right hidden cancel">{{ 'common.close'|trans }}</button>
    </form>

    <div class="wait hidden"></div>
{% endblock %}
