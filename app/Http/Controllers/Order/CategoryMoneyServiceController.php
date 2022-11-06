<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Order\CategoryMoneyService;
use App\Http\Controllers\Controller;

class CategoryMoneyServiceController extends Controller
{
    public function fetch()
    {
        $datas = CategoryMoneyService::get();
        return $datas;
    }
}
