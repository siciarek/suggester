{% extends 'templates/base.volt' %}

{% block content %}

    <h1 class="page-header">
        <i class="fa fa-lock fa-fw text-muted"></i>
        {{ 'user.sign_in'|trans }}
    </h1>

    <div class="row">
        <div class="col-md-5">

            {{ form(null, 'method': 'post', 'id' : 'suggestion-form', 'class' : 'form-horizontal') }}

            {% for m in form.getMessages() %}
                <div class="alert alert-warning">
                    <i class="fa fa-warning fa-fw fa-lg"></i>
                    {{ m.getMessage()|trans }}
                </div>
            {% endfor %}

            {% for field in [ 'csrf' ] %}
                {{ form.render(field) }}
                {% for m in form.get(field).getMessages() %}
                    <div class="alert alert-warning">
                        <i class="fa fa-warning fa-fw fa-lg"></i>
                        {{ m.getMessage()|trans }}
                    </div>
                {% endfor %}
            {% endfor %}

            <br/>

            {% for field in [ 'username', 'password' ] %}
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


            <br/>

            {{ form.render('submit', { 'class': 'btn btn-default btn-lg pull-right' }) }}
            </form>

        </div>
    </div>

{% endblock %}