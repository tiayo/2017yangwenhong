<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    /**
     * 是否可以操作
     *
     * @param $user
     * @return bool
     */
    public function control($user, $class)
    {
        return $user['id'] == $class['user_id'];
    }
}
