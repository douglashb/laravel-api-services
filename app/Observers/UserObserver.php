<?php

namespace App\Observers;

use App\Models\Profile\PasswordHistory;
use App\Models\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->savePasswordHistory($user->id, $user->password);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if (array_key_exists('password', $user->getChanges())) {
            $this->savePasswordHistory($user->id, $user->password);
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    /**
     * @param int $profileUserId
     * @param string $password
     * @return void
     */
    private function savePasswordHistory(int $profileUserId, string $password): void
    {
        PasswordHistory::create([
            'profile_user_id' => $profileUserId,
            'password' => $password,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
