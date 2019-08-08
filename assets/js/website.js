require('./LikeButton/LikeButton.js');
require('./copyLinkButton/copyLinkButton.js');
require('./Broadcasting/comments.js');
require('./bar-ui.js');
require('./jquery.mjs.nestedSortable.js');
require('./vueMethods.js');
require('./causewayAdmin/cwLanguageSwitcher.js');

window.jQuery(document).ready(function () {
    $(function () {
        // Tooltip
        $('[data-toggle="tooltip"]').tooltip()
    });
});