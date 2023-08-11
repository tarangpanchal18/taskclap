<?php

namespace App\Listeners;

use App\Events\LogUserEvent;
use App\Models\UserAuthenticationLog;
use App\Repositories\Admin\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAuthenticationUserListen
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private UserRepository $userRepository)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LogUserEvent  $event
     * @return void
     */
    public function handle(LogUserEvent $event)
    {
        $authenticatable_type = $authenticatable_id = null;
        $user = $this->userRepository->getRaw()->where('phone', $event->payload['user'])->first();
        if ($user->id) {
            $authenticatable_type = "App\Models\User";
            $authenticatable_id = $user->id;
        }
        if ($event->payload['isLoggedIn']) {
            UserAuthenticationLog::where([
                'username' => $event->payload['user'],
            ])->orderBy('id', 'DESC')->limit(1)->update([
                'login_at' => date('Y-m-d H:i:s'),
                'login_successful'=> 'Yes'
            ]);
        } else {
            UserAuthenticationLog::create([
                'username' => $event->payload['user'],
                'authenticatable_type' => $authenticatable_type,
                'authenticatable_id' => $authenticatable_id,
                'ip_address' => get_client_ip(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'login_at' => null,
                'login_successful' => 'No',
                'logout_at' => '0',
                'location' => null,
            ]);
        }
    }
}
