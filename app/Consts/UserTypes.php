<?php

namespace App\Consts;

final class UserTypes
{
    const SUPER_ADMIN = 1;

    const SUB_ADMIN = 2;

    const CUSTOMER = 3;

    // permissions for sub-admins
    const PERMISSIONS = [
        'Manage Users' => [
            'browse_users' => 'Browse Users',
            'add_user'    => 'Add User',
            'edit_user'   => 'Edit User',
            'remove_user' => 'Remove User',
        ]
    ];
}