<?php

namespace App\Http\Controllers\Api\FinancingManage;

use App\Http\Controllers\Controller;

class StockFeeController extends Controller
{
    use \App\Http\Controllers\Load\ShowTrait, \App\Http\Controllers\Load\UpdateTrait, \App\Http\Controllers\Load\StoreTrait;

    public static $model_name = 'StockFee';

    public function __construct()
    {
        $this->middleware("auth:api");
    }
}