<?php

namespace Betalectic\Permiso;

use Exception;
use Log;

use Betalectic\Permiso\Models\Permission;
use Betalectic\Permiso\Models\Entity;
use Betalectic\Permiso\Models\Group;
use Betalectic\Permiso\Models\UserPermission;

class PermissionBuilder
{
    public $userPermissions;
    public $permissions = [];

    public function __construct($userPermissions)
    {
        $this->userPermissions = $userPermissions;
        $this->permissions = [];
    }

    public function init()
    {
        $permissions = Permission::get();

        foreach($permissions as $permission)
        {
            $this->permissions[$permission->value] = [];
        }
    }

    public function findChildren($entity, $childType)
    {
        return $entity->children()->where('type',$childType)->get();
    }

    public function isPermissionRelatedToEntity($permission, $entity)
    {
       return $permission->entity_type == $entity->type;
    }

    public function allowOnAll($permission)
    {
        $this->permissions[$permission->value] = true;
    }

    public function addToPermissions($permissionValue, $value)
    {
        if(is_array($value)){

            $entities = Entity::whereIn('id',$value)->get();

            $this->permissions[$permissionValue] = array_merge(
                $this->permissions[$permissionValue],$entities->pluck('value')->toArray());

        }else{
            $entity = Entity::find($value);
            array_push($this->permissions[$permissionValue],$entity->value);
        }
    }

    public function allowOnEntity($permission, $entity)
    {
        $permissionValue = $permission->value;

        if(!is_bool($this->permissions[$permissionValue]))
        {
            // But is this permission on this entity?

            if($this->isPermissionRelatedToEntity($permission, $entity))
            {
                $this->addToPermissions($permissionValue, $entity->id);
            }
            else
            {
                // Check if this entity has any children and with relevant entity_type
                $children = $this->findChildren($entity, $permission->entity_type);

                if($children->count())
                {
                    $this->addToPermissions($permissionValue, $children->pluck('id')->toArray());
                }

            }
        }
    }
}
