<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Userpolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function storeUser(User $user)
    {
        return $user->role == 'admin' ? true : false;
    }

}
