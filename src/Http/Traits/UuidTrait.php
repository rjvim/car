<?php
namespace Betalectic\Car\Http\Traits;

use Betalectic\Car\Helpers\UUIDHelper;

trait UuidTrait
{
	public static function bootUuidTrait()
    {
        static::creating(function ($module){
            $module->uuid = self::CODE_PREFIX.UUIDHelper::generate();
        });
    }
}