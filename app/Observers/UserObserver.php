<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Periksa apakah profile_picture_1x1 berubah
        if ($user->isDirty('profile_picture_1x1')) {
            $oldProfilePicture = $user->getOriginal('profile_picture_1x1');

            // Hapus file gambar lama dari sistem file
            if ($oldProfilePicture) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldProfilePicture);
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
