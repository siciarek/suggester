var scriptParams = document.getElementById('suggester-script');
var suggesterApp = scriptParams.getAttribute('data-value');
var suggesterAuthor = scriptParams.getAttribute('data-from');

suggesterApp = suggesterApp === null ? '' : suggesterApp;
suggesterAuthor = suggesterAuthor === null ? '' : suggesterAuthor;
var suggesterFormPage = '/form?application=' + suggesterApp + '&author=' + suggesterAuthor;

var suggesterToggleButtonWidth = 48;
var suggesterToggleButtonHeight = 48;
var suggesterWindowWidth = 600;
var suggesterWindowHeight = 480;
var timerlen = 5;
var slideAniLen = 500;
var suggesterTitle = suggesterApp;

var __content_style = '\
<style type="text/css"> \
iframe#__screen { border:0; position:relative; width:' + suggesterWindowWidth + 'px; height:' + suggesterWindowHeight + 'px; right:0; top:0; z-index:32000 } \
a#__suggester_button { text-decoration: none!important; text-align: center; line-height: 36px; font-size: 32pt; font-weight: bold; \
   background-color:#EEEEEE; color:#888888; cursor:pointer; position:fixed !important; width: ' + suggesterToggleButtonWidth + 'px; height: ' + suggesterToggleButtonHeight + 'px; \
   right: 0; top: 0; z-index: 32000 } \
div#__suggester_window { display:none; overflow:hidden; position:fixed; width:' + suggesterWindowWidth + 'px; height:' + suggesterWindowHeight + 'px; \
right:' + suggesterToggleButtonWidth + 'px; top:0; padding: 0; border: 4px solid #EEEEEE; border-top:0; border-radius: 11px; border-top-left-radius: 0; border-top-right-radius: 0; \ \
background-color:#EEEEEE } \
</style>';

var timerID = [];
var startTime = [];
var obj = [];
var finalWidth = [];
var moving = [];
var dir = [];

function showPage(objname) {
    if (moving[objname]) {
        return;
    }

    if (document.getElementById(objname).style.display !== 'none') {
        return; // cannot show something that is already visible
    }

    moving[objname] = true;
    dir[objname] = "show";
    slideStart(objname);
}

function hidePage(objname) {
    if (moving[objname]) {
        return;
    }

    if (document.getElementById(objname).style.display === 'none') {
        return; // cannot hide something that is already hidden
    }

    moving[objname] = true;
    dir[objname] = 'hide';
    slideStart(objname);
}

function slideTick(objname) {

    var elapsed = (new Date()).getTime() - startTime[objname];

    if (elapsed > slideAniLen) {
        slideStop(objname)
    }
    else {
        var d = Math.round(elapsed / slideAniLen * finalWidth[objname]);

        if (dir[objname] === 'hide') {
            d = finalWidth[objname] - d;
        }

        obj[objname].style.width = d + 'px';
    }
}

function slideStart(objname) {
    obj[objname] = document.getElementById(objname);

    finalWidth[objname] = suggesterWindowWidth;
    startTime[objname] = (new Date()).getTime();

    obj[objname].style.display = 'block';
    timerID[objname] = setInterval(function () {
        slideTick(objname);
    }, timerlen);
}

function slideStop(objname) {

    clearInterval(timerID[objname]);

    if (dir[objname] == 'hide') {
        if(suggesterFormPage !== document.getElementById('__screen').getAttribute('src')) {
            document.getElementById('__screen').setAttribute('src', suggesterFormPage);
        }

        obj[objname].style.display = 'none';
    }

    obj[objname].style.width = finalWidth[objname] + 'px';

    document.getElementById('__suggester_button').innerHTML = dir[objname] === 'hide' ? '&laquo' : '&raquo;';

    delete(moving[objname]);
    delete(timerID[objname]);
    delete(startTime[objname]);
    delete(finalWidth[objname]);
    delete(obj[objname]);
    delete(dir[objname]);
}



function __toggleSuggester() {
    var screen = document.getElementById('__suggester_window');

    if (screen.style.display == 'block') {
        hidePage('__suggester_window');
    }
    else {
        showPage('__suggester_window');
    }
}

var __screen           = '<div id="__suggester_window" style="display:none"><iframe src="' + suggesterFormPage + '" id="__screen"></iframe></div>';
var __suggester_button = '<a onclick="__toggleSuggester()" id="__suggester_button" title="' + suggesterTitle + '">&laquo;</a>';
var __content          = __content_style + __screen + __suggester_button;

document.write(__content);
