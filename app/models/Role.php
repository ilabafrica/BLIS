<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
    * Function for getting the admin role, currently the first user
    *  
    */
    public static function getAdminRole()
    {
        return Role::find(1);
    }
}