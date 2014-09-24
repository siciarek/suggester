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
                        $(this).removeClass('empty');

                        if ($(this).val().trim() === '') {
                            $(this).addClass('empty');
                        }
                    })
                    .on('submit', function () {
                        var self = $(this);
                        var button = self.find('*[type=submit]');

                        if (self.find('select[name=type_id]').val().trim().length > 0 && self.find('textarea').val().trim().length > 0) {
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

            $('#suggestion-form select[name=type_id]').trigger('change');

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
    </style>
{% endblock %}

{% block content %}

    {{ form(null, 'method': 'post', 'id' : 'suggestion-form', 'class' : 'form-horizontal') }}

    {% for m in form.getMessages() %}
        <div class="alert alert-warning">
            <i class="fa fa-warning fa-fw fa-lg"></i>
            {{ m.getMessage() }}
        </div>
    {% else %}
        <div class="alert alert-info">
            <i class="fa fa-edit fa-fw fa-lg"></i>
            {{ 'suggestion.prompt'|trans }}
        </div>
    {% endfor %}

    {% for field in [ 'type_id', 'content', 'priority' ] %}
        <div class="input-group">
            {{ form.label(field, { 'class' : 'input-group-addon' }) }}
            {{ form.render(field, { 'class' : 'form-control' }) }}
        </div>
        {% for m in form.get(field).getMessages() %}
            {% if loop.first %}<ul class="text-warning">{% endif %}
            <li>{{ m.getMessage()|trans }}</li>
            {% if loop.last %}</ul>{% endif %}
        {% endfor %}
    {% endfor %}

    {% for field in [ 'csrf', 'page_url', 'author', 'application' ] %}
        {{ form.render(field) }}
    {% endfor %}

    <br/>

    {{ form.render('submit', { 'class': 'btn btn-default btn-lg pull-right' }) }}
    <button type="button" class="btn btn-default btn-lg pull-right hidden cancel">{{ 'common.close'|trans }}</button>
    </form>
{% endblock %}
