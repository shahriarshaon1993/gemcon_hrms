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
// $user=Auth::guard('user')->user();
// Broadcast::channel('App.User', function ($user) {
//     return  $user;
// });
// echo"<pre>";
// print_r(Auth::guard('user')->user()->id);
// exit();

// Broadcast::channel('events', function ($user) {
//     return 'hell';
// });
// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });