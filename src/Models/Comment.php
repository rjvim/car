<?php
namespace Betalectic\Car\Models;

use Betalectic\Car\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use UuidTrait;
	use SoftDeletes;

	const CODE_PREFIX = 'CARC-';
	protected $primaryKey = 'uuid';
    public $incrementing = false;
	protected $table = "car_comments";

    public $guarded = [];

}
