<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Content2MetaFieldsAutosave;
use App\Models\User;

class Content2MetaFieldsAutosavePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Content2MetaFieldsAutosave $content2MetaFieldsAutosave): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Content2MetaFieldsAutosave $content2MetaFieldsAutosave): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Content2MetaFieldsAutosave $content2MetaFieldsAutosave): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Content2MetaFieldsAutosave $content2MetaFieldsAutosave): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Content2MetaFieldsAutosave $content2MetaFieldsAutosave): bool
    {
        //
    }
}
