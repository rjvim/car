<?php

namespace Betalectic\Permiso;

trait Registrable
{

    public static function bootRegistrable()
    {
        static::observe(app(RegistrableObserver::class));
    }

}
