<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json(['data' => $data], $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code],$code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse($collection, $code);
    }

    protected function showNoCollection($noCollection, $code = 200)
    {
        return $this->successResponse($noCollection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }

    protected function showOneData($data, $code = 200)
    {
        return $this->successResponse($data, $code);
    }
}
