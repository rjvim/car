<?php namespace Betalectic\Permiso\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Betalectic\Permiso\Permiso;


class GroupController extends BaseController {


    public function index()
    {
        dd("groups");
    }

    public function store(Request $request)
    {
        $permiso = new Permiso();
        $group = $permiso->registerGroup(
            $request->get("name"),
            $request->get("permissions",[]),
            $request->get("display_name")
        );

        return $group;
    }

}
