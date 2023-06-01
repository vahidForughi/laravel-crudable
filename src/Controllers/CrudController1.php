<?php

namespace Generaltools\Crudable\Controllers;

use Generaltools\Crudable\Utils\Response;
use Illuminate\Support\Str;

class CrudController1 extends Controller
{


    public function boot()
    {
        Parent::boot();
    }


    function __call($name_of_function, $arguments) 
    {
        if (in_array($name_of_function, ['index','store','show','update','destroy'])) {
            $this->requestValidate($name_of_function);
            return $this->{'crud'.strtoupper($name_of_function)}($arguments);
        }

        return null;
    }


    public function crudIndex()
    {
        $params = request()->all();

        if (isset(request()->with))
          $this->instance = $this->instance->with(request()->with);

        foreach ($params as $param => $value) {
          if (in_array($param, $this->model->getFillable()))
            $this->instance = $this->instance->{Str::camel('where_'.$param)}($value);
        }

        $resources = (isset($params['paginate']) && !!$params['paginate']) ? $this->instance->paginate(isset($params['limit'])?$params['limit']:null) : $this->instance->get();

        return Response::success($resources);
    }


    public function crudStore()
    {
        $form = $this->instance->createForm(request()->all());

        $form->save();

        $values = $form->getValue();

        dd($this->instance->create($values));
        $result = $this->instance->create($values);

        return Response::success(["id" => $result->id]);
    }


    public function crudShow()
    {
        if (isset(request()->with))
          $this->instance->load(request()->with);

        return Response::success($this->instance);
    }


    public function crudUpdate()
    {
        $form = $this->instance->createForm(request()->all());

        $form->update();

        $values = $form->getValue();

        $this->instance->update($values);

        return Response::success(true);
    }


    public function crudDestroy()
    {
        $this->instance->delete();
        return Response::success(true);
    }


}
