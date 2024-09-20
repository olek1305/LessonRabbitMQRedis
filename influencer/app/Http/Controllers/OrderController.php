<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('view', 'users');

        $order = Order::paginate();

        return OrderResource::collection($order);
    }

    /**
     * @throws AuthorizationException
     */
    public function show($id)
    {
        Gate::authorize('view', 'users');

        return new OrderResource(Order::findOrFail($id));
    }

    /**
     * Export the orders to a CSV file and stream it for download.
     *
     * @throws AuthorizationException if the user is not authorized to view orders.
     * @return StreamedResponse
     */
    public function export(): StreamedResponse
    {
        Gate::authorize('view', 'users');

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"orders.csv\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () {
            $orders = Order::all();

            $file = fopen('php://output', 'w');
            // Header Row
            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Price', 'Quantity']);

            // Body
            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

}
