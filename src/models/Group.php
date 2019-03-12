<?php namespace Betalectic\Permiso\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $table = "permiso_groups";

    public $guarded = [];

    public function userPermissions()
    {
        return $this->morphMany(UserPermission::class,'of');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permiso_groups_permissions', 'group_id', 'permission_id');
    }

    public function entities()
    {
        return $this->belongsToMany(Entity::class, 'permiso_groups_entities', 'group_id', 'entity_id');
    }
}
