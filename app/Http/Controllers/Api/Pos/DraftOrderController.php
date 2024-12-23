<?php

namespace App\Http\Controllers\Api\Pos;

use App\Http\Controllers\Controller;
use App\Models\OrderDraft;
use App\Models\Product;
use Illuminate\Http\Request;

class DraftOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $draftOrders = OrderDraft::where('status', 'draft')->get();


        return response()->json([
            'status' => 'success',
            'message' => 'Get order draft successfully',
            'data' => $draftOrders
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

        $draftOrder = OrderDraft::create($request->all());

        //save to order draft items
        // foreach ($request->items as $item) {
        //     $draftOrder->items()->create($item);
        // }

        // Save to order items and update product stock
        foreach ($request->items as $item) {
            // Buat OrderItem
            $orderItem = $draftOrder->items()->create($item);

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

        return response()->json([
            'status' => 'success',
            'message' => 'Order draft created successfully',
            'data' => $draftOrder
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $draftOrder = OrderDraft::with('items')->findOrFail($id);
        //load items relationship
        $draftOrder->load('items');
        $draftOrder->load('items.product');

        return response()->json([
            'status' => 'success',
            'message' => 'Get order draft successfully',
            'data' => $draftOrder
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $draftOrder = OrderDraft::findOrFail($id);

        $draftOrder->update([
            'status' => 'paid',
            'payment_status' => 'paid',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order draft updated successfully',
            'data' => $draftOrder
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
