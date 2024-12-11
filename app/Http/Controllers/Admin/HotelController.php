<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        $prefectures = Prefecture::all(['prefecture_id', 'prefecture_name']);
        return view('admin.hotel.search', compact('prefectures'));
    }

    public function showResult(): View
    {
        $prefectures = Prefecture::all(['prefecture_id', 'prefecture_name']);
        return view('admin.hotel.result', compact('prefectures'));
    }

    public function showEdit(int $id): View
    {
        $hotel = Hotel::findOrFail($id);
        $prefectures = Prefecture::all(['prefecture_id', 'prefecture_name']);

        return view('admin.hotel.edit', compact('hotel', 'prefectures'));
    }


    public function showCreate(): View
    {
        $prefectures = Prefecture::all(['prefecture_id', 'prefecture_name']);
        return view('admin.hotel.create', compact('prefectures'));
    }


    /** post methods */

    public function searchResult(Request $request): View
    {
        $validated = $request->validate([
            'hotel_name' => 'nullable|string|max:255',
            'prefecture_id' => 'nullable|exists:prefectures,prefecture_id',
        ]);

        $var = [];

        $hotelList = Hotel::getHotelListByName(
            $validated['hotel_name'] ?? '',
            $validated['prefecture_id'] ?? null
        );
        $var['hotelList'] = $hotelList;
        $var['prefectures'] = Prefecture::all(['prefecture_id', 'prefecture_name']);

        return view('admin.hotel.result', $var);
    }

    public function edit(Request $request, int $id)
    {
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $hotel = Hotel::findOrFail($id);

        if ($request->hasFile('file_path')) {
            $destinationPath = public_path('assets/img/hotel');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $fileName = time() . '_' . $request->file('file_path')->getClientOriginalName();
            $request->file('file_path')->move($destinationPath, $fileName);
            $filePath = 'hotel/' . $fileName;
            $hotel->file_path = $filePath;
        }

        $hotel->hotel_name = $validated['hotel_name'];
        $hotel->prefecture_id = $validated['prefecture_id'];
        $hotel->save();

        return redirect()->back()->with('success', 'Hotel updated successfully!');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|exists:prefectures,prefecture_id',
            'file_path' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $destinationPath = public_path('assets/img/hotel');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $fileName = time() . '_' . $request->file('file_path')->getClientOriginalName();
            $request->file('file_path')->move($destinationPath, $fileName);
            $filePath = 'hotel/' . $fileName;
        }

        Hotel::create([
            'hotel_name' => $validated['hotel_name'],
            'prefecture_id' => $validated['prefecture_id'],
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Hotel created successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->input('hotel_id');
        $hotel = Hotel::find($id);
        if ($hotel) {
            $hotel->delete();

            return redirect()->route('adminHotelSearchPage');
        }

        return redirect()->route('adminHotelSearchPage');
    }
}
