<?php

namespace Generaltools\Crudable\Utils;

use \Illuminate\Http\JsonResponse;

class Response
{


    static public function create($success ,$status=200, $error=null, $data=null, $messages=null) : JsonResponse
    {
      return response()->json(
        [
          'success' => $success,
          'status' => $status,
          'errors' => $error,
          'data' => $data,
          'messages' => $messages
        ]
        ,$status);
    }


    static public function success($data=null, $messages=null) : JsonResponse
    {
      return self::create(true, 200, null, $data, $messages);
    }


    static public function error($status=400, $error=null, $messages=null) : JsonResponse
    {
      return self::create(false, $status, $error, null, $messages);
    }

}
