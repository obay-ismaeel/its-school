<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CalendarItem;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    function index() {
        $items = CalendarItem::all();
        $items = $items->mapToGroups(function($item){ return [$item['date'] => $item->toArray()]; });
        $items = $items->map(function($item){ return $item->toArray(); });
        return response()->json([
            'message' => 'success',
            'data' => $items
        ],200);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'date' => 'required',
            'title' =>  'required',
            'content' => 'required',
            'type' => 'required'
        ]);

        $calendarItem = CalendarItem::create($attributes);

        return response()->json([
            'status' => true,
            'message' => 'Calendar item has added succssfully',
            'calendaritem' => $calendarItem
        ], 201);
    }
}
