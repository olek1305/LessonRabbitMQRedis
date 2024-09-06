<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChartResource;
use App\Models\Order;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DashboardController extends Controller
{
    /**
     * Display a chart of total order values grouped by date.
     *
     * @throws AuthorizationException If the user is not authorized to view the dashboard.
     * @return AnonymousResourceCollection A collection of chart resources representing total order values by date.
     */
    public function chart(): AnonymousResourceCollection
    {
        Gate::authorize('view', 'dashboard');

        $orders = Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, SUM(order_items.quantity*order_items.price) as sum")
            ->groupBy('date')
            ->get();

        return ChartResource::collection($orders);
    }
}
