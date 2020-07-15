<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('messages.{id}', function ($user, $id) {
    return (int) $user->id === (int)$id;
});

Broadcast::channel('groupusers.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('groupusersdelete.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('messagesforgroup.{id}', function ($user, $id) {
    return (int) $user->id === (int)$id;
});

Broadcast::channel('newnotificationread.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('alertforuser.{id}', function ($user, $id) {
    return (int) $user->id === (int)$id;
});
Broadcast::channel('commentfortask.{id}', function ($user, $id) {
    return (int) $user->id === (int)$id;
});
/*Broadcast::channel('groups.{group}', function ($user, Group $group) {
    return $group->hasUser($user->id);
});*/
