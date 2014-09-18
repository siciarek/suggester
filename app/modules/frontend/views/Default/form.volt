{% extends 'templates/base.volt' %}

{% block javascripts %}
    {{ super() }}
    <script>
    $(document).ready(function() {
        $('#suggestion-form').on('click', '*[type=submit]', function(e){
            var form = $(this).parent();
            form.find('*[name=page_url]').val(parent.location.href);
            form.submit();
        });
    });
    </script>
{% endblock %}

{% block content %}
    <div class="alert alert-info">{{ 'suggestion.prompt'|trans }}</div>

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
    </form>
{% endblock %}

{% block stylesheets %}
    {{ super() }}
    <style>
        body {
            padding: 24px;
        }
        .btn {
            width: 150px;
        }
    </style>
{% endblock %}