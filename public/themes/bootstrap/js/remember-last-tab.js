var _remember_last_tab_cookie_name = "__LAST_TAB";

function setLastTab(a) {
    $.cookie(_remember_last_tab_cookie_name, a, {path: "/"})
}

function getLastTab() {
    return $.cookie(_remember_last_tab_cookie_name)
}

function rememberLastTab(b) {
    $("." + b + ' a[data-toggle="tab"]').on("click", function (c) {
        setLastTab($(c.target).attr("href"))
    });
    var a = getLastTab();
    if (a) {
        $("." + b + " a[href=" + a + "]").tab("show")
    } else {
        $("." + b + ' a[data-toggle="tab"]:first').trigger("click")
    }
}

function clearLastTab() {
    return $.removeCookie(_remember_last_tab_cookie_name, {path: "/"})
}