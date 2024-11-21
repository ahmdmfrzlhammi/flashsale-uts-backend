<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FlashSaleService;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    // Get all active flash sales
    public function index()
    {
        $flashSales = FlashSale::with('product')
            ->where('end_time', '>', now())
            ->get();

        return response()->json($flashSales);
    }

    // Create a flash sale
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discounted_price' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $flashSale = FlashSale::create($validated);

        return response()->json([
            'message' => 'Flash Sale created successfully',
            'flashSale' => $flashSale,
        ]);
    }

    // Update a flash sale
    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'exists:products,id',
            'discounted_price' => 'numeric',
            'start_time' => 'date',
            'end_time' => 'date|after:start_time',
        ]);

        $flashSale->update($validated);

        return response()->json([
            'message' => 'Flash Sale updated successfully',
            'flashSale' => $flashSale,
        ]);
    }

    // Delete a flash sale
    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        return response()->json(['message' => 'Flash Sale deleted successfully']);
    }
}
