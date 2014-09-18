{% set menu = [
{ 'href':'#intro', 'text': 'menu.intro', 'icon': 'fa-home' },
{ 'href':'#textcontent', 'text': 'menu.info', 'icon': 'fa-info-circle' },
{ 'href':'#grid', 'text': 'menu.music_records', 'icon': 'fa-volume-up' },
{ 'href':'#carousel', 'text': 'menu.video', 'icon': 'fa-film' },
{ 'href':'#gallery', 'text': 'menu.photos', 'icon': 'fa-camera-retro' },
{ 'href':'#contact', 'text': 'menu.contact', 'icon': 'fa-envelope-o' }
] %}

<section id="menu">
    <div class="pagelogo">
        <div class="special-element center hidden-xs"><span></span></div>
        <a href="#intro" class="scroll"><strong>{{ app_short_name }}</strong></a>
    </div>
    <div class="menuswitch">
        <a href="#" id="menuswitcher">
            <span class="fa fa-bars"></span>
        </a>
    </div>
    <div class="navigation">
        <ul class="nav">
            {% for i in menu %}
            <li><a href="{{ i['href'] }}" class="scroll"><span class="fa {{ i['icon'] }}"></span> {{ i['text']|trans }}</a></li>
            {% endfor %}
            {#<li><a href="#intro" class="scroll"><span class="fa fa-home"></span> {{ 'menu.info'|trans }}</a></li>#}
            {#<li><a href="#info" class="scroll"><span class="fa fa-info-circle"></span> Text</a></li>#}
            {#<li><a href="#grid" class="scroll"><span class="fa fa-th"></span> Grid</a></li>#}
            {#<li><a href="#carousel" class="scroll"><span class="fa fa-arrows-h"></span> Carousel</a></li>#}
            {#<li><a href="#gallery" class="scroll"><span class="fa fa-image"></span> Gallery</a></li>#}
            {#<li><a href="#contact" class="scroll"><span class="fa fa-envelope-o"></span> Contact</a></li>#}
        </ul>
    </div>
</section>
