window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('fullcalendar');
    require('datatables.net-bs4');
    require('jquery-ui');
    require('jquery-ui/ui/widgets/sortable');
    require('jquery-ui/ui/effect.js');
    require('summernote');
    require('frontwise-grid-editor');
    require('blueimp-file-upload');
    require('lightbox2');
    require('soundmanager2');

} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'], // <-- only use ws and wss as valid transports
});

window.Echo.private('users.notification.thread.' + Laravel.threadId)
    .listen('CommentNotificationCreated', (data) => {
        var result = $.parseJSON(data.comment.data);
        $('#forumReply').after('<li class="list-group-item list-group-item-action flex-column align-items-start">\n' +
            '<div class="commenterImage">\n' +
            '</div>\n' +
            '<div class="commentText">\n' +
            '<p><strong>' + result.name + '</strong></p>\n' +
            '<p>' + result.comment + '</p>\n' +
            '<div class="clearfix"><span class="date sub-text btn btn-sm btn-like btn-outline-dark">on ' + result.formatted_date + '</span>\n' +
            '<a href="/ajax/like/type/#LIKETYPE#/id/#LIKEID#" class="btn-like btn btn-sm btn-primary btn-counter"\n' +
            '><i class="fa fa-heart"></i></a>' +
            '<a href="#" class="btn btn-sm btn-primary btn-like pull-right">\n' +
            'Quote\n' +
            '</a>' +
            '</div></div>\n' +
            '</li>');
    });
