<?php

namespace App\Http\Controllers;

use App\Consts\UserTypes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAllowedPermissions($string = false)
    {
        $allowedPermissions
            = collect(UserTypes::PERMISSIONS)
                ->reduce(function($acc,$permissions) {
                    return \array_merge($acc, \array_keys($permissions));
                }, []);

        return $string ?
            \implode(',', $allowedPermissions) :
            $allowedPermissions;
    }
}
