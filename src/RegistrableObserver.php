<?php

namespace Betalectic\Permiso;

use Illuminate\Database\Eloquent\Model;

class RegistrableObserver
{
    private $permiso;

    public function __construct(Permiso $permiso)
    {
        $this->permiso = $permiso;
    }

    public function registerParents(Model $model)
    {
        if(!is_null($model->registrableParents) && count($model->registrableParents))
        {
            foreach($model->registrableParents as $parent)
            {
                $parentModel = $model;

                foreach(explode('.',$parent) as $up)
                {
                    // $parentModel -> field.asset.businessUnit
                    // $parentModel->field->asset->businessUnit
                    $parentModel = $parentModel->$up;
                }

                $this->permiso->setParent($model, $parentModel);
            }

        }

        $this->permiso->registerEntity($model);
    }

    public function created(Model $model)
    {
        $this->registerParents($model);
    }

    public function updated(Model $model)
    {
        $this->permiso->deleteParents($model);
        $this->registerParents($model);
    }
    // public function deleting(Model $model)
    // {
    //     $this->permiso->deregisterEntity($model);
    // }
}
