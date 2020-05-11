<?php

namespace App\Traits;

use Illuminate\Http\Response;


trait ApiResponser
{

     /*
     * @param   string|array $data  
     * @param   int  $code     ]
     *
     * @return  Illuminate\Http\Response     
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data, 'code' => $code],$code)
    }


    /**
     * [errorResponse description]
     *
     * @param   string $message  
     * @param   int  $code     
     *
     * @return  Illuminate\Http\Response     
     */
    public function errorResponse($message, $code )
    {
        return response()->json(['error' => $message,'code' => $code],$code)
    }

}