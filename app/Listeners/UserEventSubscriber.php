<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use App\Models\User; // <-- Tambahkan ini

class UserEventSubscriber
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param \Illuminate\Auth\Events\Login $event
     */
    public function handleLogin(Login $event)
    {
        /** @var User $user */ // <-- Beritahu IDE bahwa $user adalah instance dari User
        $user = $event->user;

        activity()
           ->causedBy($user)
           ->log('Pengguna berhasil masuk');
    }

    /**
     * @param \Illuminate\Auth\Events\Failed $event
     */
    public function handleFailedLogin(Failed $event)
    {
        $email = $event->credentials['email'] ?? 'N/A';
        activity()
           ->log("Percobaan masuk gagal untuk email: {$email}");
    }

    /**
     * @param \Illuminate\Auth\Events\Logout $event
     */
    public function handleLogout(Logout $event)
    {
        /** @var User|null $user */ // <-- Beritahu IDE bahwa $user bisa jadi User atau null
        $user = $event->user;

        if ($user) {
            activity()
               ->causedBy($user)
               ->log('Pengguna berhasil keluar');
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events): array
    {
        return [
            Login::class => 'handleLogin',
            Failed::class => 'handleFailedLogin',
            Logout::class => 'handleLogout',
        ];
    }
}