<?php

namespace Betalectic\Permiso;

use Exception;

use Betalectic\Permiso\Models\Permission;
use Betalectic\Permiso\Models\Entity;
use Betalectic\Permiso\Models\Group;
use Betalectic\Permiso\Models\UserPermission;

class PermissionDenier extends PermissionActions
{

    public function commit()
    {
        if(!is_null($this->permission)) // Group would be empty
        {
            UserPermission::where([
                'of_id' => $this->permission->id,
                'of_type' => get_class($this->permission),
                'user_id' => $this->user->id,
                'entity_id' => !is_null($this->entity) ? $this->entity->id : NULL
            ])->delete();
        }

        if(!is_null($this->group)) // Permission would be empty
        {
            UserPermission::where([
                'of_id' => $this->group->id,
                'of_type' => get_class($this->group),
                'user_id' => $this->user->id,
                'entity_id' => !is_null($this->entity) ? $this->entity->id : NULL
            ])->delete();
        }

        if(is_null($this->permission) && is_null($this->group) && !is_null($this->entity))
        {
            // Remove all existing permissions on this entity
            UserPermission::where([
                'user_id' => $this->user->id,
                'entity_id' => $this->entity->id
            ])->delete();
        }

    }
}
