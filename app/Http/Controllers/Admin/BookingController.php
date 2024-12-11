<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Show the booking search form.
     */
    public function showSearch(): View
    {
        return view('admin.booking.search');
    }

    /**
     * Handle booking search results.
     */
    public function searchResult(Request $request): View
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_contact' => 'nullable|string|max:255',
            'checkin_time' => 'nullable|date',
            'checkout_time' => 'nullable|date|after_or_equal:checkin_time',
        ]);

        $query = Booking::query();

        if (!empty($validated['customer_name'])) {
            $query->where('customer_name', 'like', '%' . $validated['customer_name'] . '%');
        }

        if (!empty($validated['customer_contact'])) {
            $query->where('customer_contact', 'like', '%' . $validated['customer_contact'] . '%');
        }

        if (!empty($validated['checkin_time'])) {
            $query->where('checkin_time', '>=', $validated['checkin_time']);
        }

        if (!empty($validated['checkout_time'])) {
            $query->where('checkout_time', '<=', $validated['checkout_time']);
        }

        $bookings = $query->get();

        return view('admin.booking.result', ['bookings' => $bookings]);
    }
}
