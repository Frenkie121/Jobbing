<?php

namespace App\Listeners;

use App\Events\Logged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SaveLoginHistory
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\Logged  $event
     * @return void
     */
    public function handle(Logged $event)
    {
        DB::table('login_history')->insert([
            'user_id' => $event->user->id,
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => request()->ip(),
            'logged_at' => now(),
        ]);
    }
}
