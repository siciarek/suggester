{% extends 'templates/base.volt' %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {

        });
    </script>
{% endblock %}

{% block stylesheets %}
    {{ super() }}
    <style>

    </style>
{% endblock %}

{% block content %}

    <h1 class="page-header">
        <i class="fa fa-list-alt fa-fw text-muted"></i>
        {% if form.getEntity().getId() == null %}
            {{ 'user.create'|trans }}
        {% else %}
            {{ 'user.edit'|trans({'name':  form.getEntity().getUsername() }) }}
        {% endif %}
    </h1>

    <div class="row">
        <div class="col-lg-6">
            {{ form(null, 'method': 'post', 'id' : 'user-form', 'class' : 'form-horizontal') }}

            {% for m in form.getMessages() %}
                <div class="alert alert-warning">
                    <i class="fa fa-warning fa-fw fa-lg"></i>
                    {{ m.getMessage() }}
                </div>
            {% endfor %}

            {% for field in [ 'username', 'email', 'first_name', 'last_name', 'description' ] %}
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

            {% for field in [ 'csrf' ] %}
                {{ form.render(field) }}
            {% endfor %}

            <br/>

            {{ form.render('submit', { 'class': 'btn btn-default btn-lg pull-right' }) }}
            </form>
        </div>
        <div class="col-lg-6">
        </div>
    </div>

{% endblock %}