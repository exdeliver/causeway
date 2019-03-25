<?php

Broadcast::channel('users.notification.thread.{threadId}', function ($user, $threadId) {
    return true;
});