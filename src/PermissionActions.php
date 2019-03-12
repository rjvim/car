<?php

namespace Betalectic\Permiso;

use Exception;

use Betalectic\Permiso\Models\Permission;
use Betalectic\Permiso\Models\Entity;
use Betalectic\Permiso\Models\Group;
use Betalectic\Permiso\Models\UserPermission;

class PermissionActions
{
    public $user;
    public $permission = NULL;
    public $entity = NULL;
    public $group = NULL;
    public $uniqueness = false;
    public $children = NULL;
    public $meta = [];

    public $hasGlobalPermission = false;
    public $hasGlobalGroupPermission = false;
    public $hasEntityPermission = false;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function setUniqueness($value)
    {
        /**
            This means, on the same entity, you can't have two groups.
        **/

        $this->uniqueness = $value;
    }

    public function meta($meta)
    {
        $this->meta = $meta;
    }

    public function children($children)
    {
        $this->children = $children;
    }

    public function entity($entity)
    {
        $this->entity = Entity::firstOrCreate([
            'type' => get_class($entity),
            'value' => $entity->getKey(),
        ]);

        $entityPermission = $this->getEntityPermission();

        $this->hasEntityPermission = !is_null($entityPermission) ? true : false;
    }

    public function group($groupName)
    {
        $this->group = Group::whereName($groupName)->first();

        $globalPermissions = $this->getGlobalGroupPermissions();

        if($globalPermissions->count())
        {
            $this->hasGlobalGroupPermission = true;
        }
    }

    public function permission($permission)
    {
        $this->permission =
        Permission::whereValue($permission)->firstOrFail();

        $globalPermissions = $this->getGlobalPermissions();

        if($globalPermissions->count())
        {
            $this->hasGlobalPermission = true;
        }
    }

    public function getEntityPermission()
    {
        $entityPermission = UserPermission::where([
                                'user_id' => $this->user->id,
                                'entity_id' => $this->entity->id
                            ])
                            ->first();

        return $entityPermission;
    }

    public function getGlobalPermissions()
    {
        $userPermissions = $this->permission
                            ->userPermissions()
                            ->where('user_id',$this->user->id)
                            ->whereNull('entity_id')
                            ->get();

        return $userPermissions;
    }

    public function getGlobalGroupPermissions()
    {
        $userPermissions = $this->group
                            ->userPermissions()
                            ->where('user_id',$this->user->id)
                            ->whereNull('entity_id')
                            ->get();

        return $userPermissions;
    }
}
