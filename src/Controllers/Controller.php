<?php

namespace Generaltools\Crudable\Controllers;

use Generaltools\Crudable\Classes\Concerns\EntitiesRequests;
use Generaltools\Crudable\Classes\Concerns\ModelsRequests;
use App\Http\Requests\ArticleRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//    , ModelsRequests, EntitiesRequests;


    public function boot()
    {
        // $this->parseModel();
        // $this->parseRelation();
        // $this->getInstance();

        // $this->parseEntity($this->modelName);

        // $this->setModelProperties($this->entity);
        // $this->setModelRelations($this->entity->relations);



//        $this->parseRequest();
//        $this->requestAuthorization();
//        $this->requestValidate();
    }


    function requestAuthorization()
    {
//        $this->authorize('store',[]);
    }


    function requestValidate($route)
    {
        request()->validate($this->entity->getRules($route));
    }


}
