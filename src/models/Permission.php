<?php namespace Betalectic\Permiso\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = "permiso_permissions";

    public $guarded = [];

    public function userPermissions()
    {
        return $this->morphMany(UserPermission::class,'of');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'permiso_groups_permissions','permission_id','group_id');
    }
}
