<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * 是否超级管理员
     *
     * @param $user
     * @return bool
     */
    public function admin($user, $class)
    {
        return config('site.administrator') == $user['email'];
    }

    /**
     * 是否商户账号
     *
     * @param $user
     * @param $class
     * @return bool
     */
    public function business($user, $class)
    {
       return $user['type'] == 2;
    }
}
