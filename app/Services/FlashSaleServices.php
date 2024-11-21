<?php
namespace App\Services;

use App\Models\FlashSale;
use Illuminate\Support\Carbon;

class FlashSaleService
{
    /**
     * Get active flash sales
     */
    public function getActiveFlashSales()
    {
        return FlashSale::with('product')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->get();
    }

    /**
     * Check if a product is part of an active flash sale
     *
     * @param int $productId
     * @return bool
     */
    public function isProductInFlashSale($productId)
    {
        return FlashSale::where('product_id', $productId)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->exists();
    }

    /**
     * Create a new flash sale
     *
     * @param array $data
     * @return FlashSale
     */
    public function createFlashSale(array $data)
    {
        return FlashSale::create($data);
    }

    /**
     * Update an existing flash sale
     *
     * @param FlashSale $flashSale
     * @param array $data
     * @return FlashSale
     */
    public function updateFlashSale(FlashSale $flashSale, array $data)
    {
        $flashSale->update($data);
        return $flashSale;
    }

    /**
     * Delete a flash sale
     *
     * @param FlashSale $flashSale
     * @return void
     */
    public function deleteFlashSale(FlashSale $flashSale)
    {
        $flashSale->delete();
    }
}
