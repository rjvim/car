<?php
namespace Betalectic\Car\Models;

use Betalectic\Car\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
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
