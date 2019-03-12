<?php namespace Betalectic\Permiso\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model {

	protected $table = "permiso_entities";

    public $guarded = [];

    public function children()
    {
        return $this->belongsToMany(Entity::class,'permiso_entity_parents','parent_id','child_id');
    }

    public function parents()
    {
        return $this->belongsToMany(Entity::class,'permiso_entity_parents','child_id','parent_id');
    }
}
