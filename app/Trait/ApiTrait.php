<?php

namespace App\Trait;

use Illuminate\Validation\Validator;

trait ApiTrait
{

    public function send($success, $message,$status,$data=null)
    {
        return response()->json([
            'success'=>$success,
            'message' => $message,
            'status' => $status,
            'data' => $data,

        ]);
    }

}
