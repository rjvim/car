<?php namespace Betalectic\Permiso\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Betalectic\Permiso\Permiso;
use Betalectic\Permiso\Models\User;

class GrantController extends BaseController {

    public function store(Request $request)
    {
        $permiso = new Permiso();

        $user = User::find($request->user);

        if($request->has('group'))
        {
            $group = $request->group;

            if($request->has('entity_id'))
            {
                $model = new $request->entity_type;
                $entity = $model->find($request->entity_id);

                $userPermission = $permiso->grantOnGroupAndEntity($user,$group,$entity);
            }
            else
            {
                $userPermission = $permiso->grantOnGroup($user,$group);
            }
        }

        if($request->has('permission'))
        {
            $permission = $request->permission;

            if($request->has('entity_id'))
            {
                $permiso->grantPermissionOnEntity($user, $permission, $entity);
            }
            else
            {
                $permiso->grantPermission($user,$permission);
            }
        }

        return response("success");


    }

}
