{% extends 'templates/base.volt' %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            $('#suggestion-form')
                    .on('submit', function() {
                        var self = $(this);
                        var button = self.find('*[type=submit]');

                        if(self.find('textarea').val().trim().length > 0) {
                            button.addClass('disabled');
                        }
                    })
                    .on('click', '*[type=submit]', function (e) {
                        var self = $(this);
                        var form = self.parent();
                        form.find('*[name=page_url]').val(parent.location.href);
                        form.find('textarea').val(form.find('textarea').val().trim());

                        form.submit();
                    })
                    .on('click', '.btn.cancel', function (e) {
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
    <button type="button" class="btn btn-default btn-lg pull-right cancel">{{ 'common.close'|trans }}</button>
    </form>
{% endblock %}
