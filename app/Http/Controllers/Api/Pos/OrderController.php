<?php

namespace App\Http\Controllers\Api\Pos;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Get order successfully',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'customer_note' => 'nullable',
            'order_number' => 'required',
            'total' => 'required',
            'status' => 'required',
            'payment_status' => 'required',
            'payment_type' => 'nullable',
            'items' => 'required|array',
        ]);

        $order = Order::create($request->all());

        // Save to order items and update product stock
        foreach ($request->items as $item) {
            // Buat OrderItem
            $orderItem = $order->items()->create($item);

            // Kurangi stok produk
            $product = Product::find($item['product_id']);
            if ($product) {
                if ($product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Stock not sufficient for product ID: {$item['product_id']}",
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Product not found with ID: {$item['product_id']}",
                ], 404);
            }
        }

        $order->load('items.product');

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
