window.cwChangeLanguage = function (url, selection) {
    var language = (selection.value || selection.options[selection.selectedIndex].value);
    var url = new URL(url);
    url.searchParams.append('language', language);
    // var result = confirm('Are you sure?');
    // if (result === true) {
    window.location.href = url;
    // }
};