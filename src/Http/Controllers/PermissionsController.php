<?php

namespace Betalectic\Permiso\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Betalectic\Permiso\Permiso;
use Illuminate\Http\Request;
use Betalectic\Permiso\Http\Resources\Permission as PermissionResource;

class PermissionsController extends BaseController{


    public function index(Request $request)
    {
        $permiso = new Permiso();
        $permissions = $permiso->getPermissions($request->get('entities',[]));

        return PermissionResource::collection($permissions);
    }

}
