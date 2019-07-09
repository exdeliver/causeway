<?php

namespace Exdeliver\Causeway\Domain\Services;

use Carbon\Carbon;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Exdeliver\Causeway\Domain\Entities\Shop\ProductBookingDates\BookingDate;

/**
 * Class ProductBookingsService
 * @package Exdeliver\Causeway\Domain\Services
 */
final class ProductBookingsService
{
    /**
     * @param array $bookings
     * @param Product $product
     * @return array
     */
    public function saveBookings(array $bookings, Product $product)
    {
        $result = [];
        foreach ($bookings['booking'] as $booking) {
            $result[] = BookingDate::updateOrCreate(
                [
                    'date_from' => Carbon::parse($booking['date_from']),
                    'date_to' => Carbon::parse($booking['date_to']),
                    'product_id' => $product->id,
                ],
                [
                    'gross_price' => $booking['gross_price'],
                    'special_price' => $booking['special_price'],
                    'quantity' => $booking['quantity'] ?? 1,
                    'active' => $booking['active'] ?? 0,
                ]
            );
        }

        $result = collect($result);

        // Delete removed lines.
        $deleted = BookingDate::whereNotIn('id', $result->pluck('id'))->delete();

        return $result;
    }
}
