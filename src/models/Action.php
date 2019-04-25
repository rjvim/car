<?php
namespace Betalectic\Car\Models;

use Illuminate\Database\Eloquent\Model;
use Betalectic\Car\Http\Traits\UuidTrait;
use Betalectic\Car\Models\ActionAssignedUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
	use UuidTrait;
	use SoftDeletes;

	const CODE_PREFIX = 'CARA-';
	protected $primaryKey = 'uuid';
    public $incrementing = false;
	protected $table = "car_actions";

	public $guarded = [];

}
