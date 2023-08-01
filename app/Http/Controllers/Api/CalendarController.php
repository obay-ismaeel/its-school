<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CalendarItem;

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
}
