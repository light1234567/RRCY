<?php
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;

Event::listen(Login::class, function ($event) {
    $event->user->update(['login_at' => now()]);
});

Event::listen(Logout::class, function ($event) {
    $event->user->update(['logout_at' => now()]);
});
