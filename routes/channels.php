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

Broadcast::channel('newTask', function(){
    return true;
});

// Broadcast::channel('taskRemoved', function(){
//     return true;
// });

// Broadcast::channel('DiningTableStatus', function(){
//     return true;
// });

// Broadcast::channel('KitchenQueueOrderFetch', function (){
//     return true;
// });

// Broadcast::channel('WaitressQueueOrderProcessing', function (){
//     return true;
// });

Broadcast::channel('KsherPayEvent', function (){
    return true;
});


