*/986532.0
.3+69*-<?php

use App\Rate;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('admin', function () {
    $admin = new \App\User();
    $admin->name = 'admin';
    $admin->email = 'admin@admin.com';
    $admin->password = \Illuminate\Support\Facades\Hash::make('12qwasZX');
    $admin->role = 'admin';
    $admin->email_verified_at = now();
    $admin->save();
});

Artisan::command('test', function () {
    $tags[] = \App\Tag::find(2);
    $tags[] = \App\Tag::find(3);
    print(\App\Product::find(3)->tags->contains($tags));
});
