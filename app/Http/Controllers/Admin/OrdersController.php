<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Orders\OrderParamsDto;
use App\Http\Controllers\Controller;
use App\Services\Orders\Interfaces\OrdersService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct(
        private OrdersService $ordersService
    ) {
        
    }

    /**
     * Show the admin orders page
     */
    public function index(Request $request) {
        $params = OrderParamsDto::fromRequest($request);

        $orders = $this->ordersService->getOrdersByParams($params);

        $this->appendPaginatorURL($orders);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the admin order detail page
     */
    public function show(Request $request, $code) {
        $order = $this->ordersService->getOrderByCode($code);

        return view('admin.orders.show', compact('order'));
    }
}
