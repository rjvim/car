<?php namespace Betalectic\Permiso\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Betalectic\Permiso\Permiso;


class AccessController extends BaseController {


    public function index(Request $request, $user)
    {
        // \Artisan::call("cb:load_permiso_entities");

        $permiso = new Permiso();
        return $permiso->build($user);
    }

}
