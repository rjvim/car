<?php

namespace Betalectic\Permiso;

use Exception;

use Betalectic\Permiso\Models\Permission;
use Betalectic\Permiso\Models\Entity;
use Betalectic\Permiso\Models\Group;
use Betalectic\Permiso\Models\UserPermission;

class PermissionGrantor extends PermissionActions
{

    public function commit()
    {
        $userPermission = null;

        if(!is_null($this->permission)) // Group would be empty
        {
            // If user doesn't have global permission, we can give entity permission

            if(!$this->hasGlobalPermission)
            {
                $userPermission = UserPermission::firstOrCreate([
                    'of_id' => $this->permission->id,
                    'of_type' => get_class($this->permission),
                    'user_id' => $this->user->id,
                    'entity_id' => !is_null($this->entity) ? $this->entity->id : NULL,
                    'child_permissions' => !is_null($this->children) ? $this->children : NULL
                ]);
            }
        }

        if(!is_null($this->group)) // Permission would be empty
        {

            if($this->uniqueness)
            {
                $userPermission = UserPermission::where([
                    'entity_id' => !is_null($this->entity) ? $this->entity->id : NULL,
                    'of_type' => get_class($this->group),
                    'user_id' => $this->user->id
                ])->delete();
            }

            if(!$this->hasGlobalGroupPermission)
            {
                $userPermission = UserPermission::firstOrCreate([
                    'of_id' => $this->group->id,
                    'of_type' => get_class($this->group),
                    'user_id' => $this->user->id,
                    'entity_id' => !is_null($this->entity) ? $this->entity->id : NULL,
                    'child_permissions' => !is_null($this->children) ? $this->children : NULL
                ]);
            }
        }

        if(is_null($this->permission) && is_null($this->group) && !is_null($this->entity))
        {
            // Remove all existing permissions on this entity
            UserPermission::where([
                'user_id' => $this->user->id,
                'entity_id' => $this->entity->id
            ])->delete();

            // Because, we have a permission which gives complete access to entity
            $userPermission = UserPermission::create([
                'user_id' => $this->user->id,
                'entity_id' => $this->entity->id,
                'child_permissions' => !is_null($this->children) ? $this->children : NULL
            ]);
        }

        if(!is_null($userPermission))
        {
            $userPermission->meta = $this->meta;
            $userPermission->save();
        }

    }
}
