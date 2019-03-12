<?php

namespace Betalectic\Permiso;

use Betalectic\Permiso\Models\Permission;
use Betalectic\Permiso\Models\Group;
use Betalectic\Permiso\Models\UserPermission;

use Betalectic\Permiso\PermissionBuilder;
use Log;

class Build
{
    public $permissions;
    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->permissions = [];
    }

    public function make()
    {

        $userPermissions = UserPermission::where('user_id',$this->userId)->get();

        $permissionBuilder = new PermissionBuilder($userPermissions);
        $permissionBuilder->init();

        foreach($userPermissions as $userPermission)
        {
            if($userPermission->of instanceof \Betalectic\Permiso\Models\Permission)
            {
                if($userPermission->entity)
                {
                    $permissionBuilder->allowOnEntity($userPermission->of, $userPermission->entity);
                }
                else
                {
                    $permissionBuilder->allowOnAll($userPermission->of);
                }
            }

            if($userPermission->of instanceof \Betalectic\Permiso\Models\Group)
            {
                foreach($userPermission->of->permissions as $permission)
                {
                    if($userPermission->entity)
                    {
                        $permissionBuilder->allowOnEntity($permission,$userPermission->entity);
                    }
                    else
                    {
                        $permissionBuilder->allowOnAll($permission);
                    }

                }
            }

            if(is_null($userPermission->of) && !is_null($userPermission->entity))
            {
                $permissions = Permission::whereEntityType($userPermission->entity->type)->get();

                foreach($permissions as $permission)
                {
                    $permissionBuilder->allowOnEntity($permission, $userPermission->entity);
                }
            }

            if(!is_null($userPermission->child_permissions))
            {
                foreach($userPermission->child_permissions as $childPermission)
                {
                    $permission = Permission::whereValue($childPermission)->first();

                    if($userPermission->entity)
                    {
                        $permissionBuilder->allowOnEntity($permission, $userPermission->entity);
                    }
                    else
                    {
                        $permissionBuilder->allowOnAll($permission);
                    }
                }
            }

        }

        return $permissionBuilder->permissions;


        return $this->permissions;

        foreach($userPermissions as $userPermission)
        {
            $permission = $userPermission->permission;

            if(is_null($permission->entity)){
                $this->permissions[$permission->value] = true;
            }
            else{
                if(is_null($permission->entity_id)){
                    $this->permissions[$permission->value] = true;
                }else{
                    array_push($this->permissions[$permission->value], $permission->entity_id);
                }
            }
        }

        return $this->permissions;

        // Fetch users groups
        $userGroups = $user->groups;

        foreach($userGroups as $userGroup)
        {
            foreach($userGroup->permissions as $permission)
            {
                if(is_null($permission->entity)){
                    $this->permissions[$permission->value] = true;
                }
                else{
                    $entities = $userGroup->entities;

                    foreach($entities as $entity)
                    {
                        // If there is no entity, does user get to approve all entities?
                        if($entity->entity == $permission->entity)
                        {
                            array_push($this->permissions[$permission->value], $entity->entity_id);
                        }
                    }
                }
            }
        }

        return $this->permissions;
    }

}
