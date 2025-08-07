<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopCategoryPosition;

class AppTopCategoryController extends Controller
{
    public function index(Request $request)
    {
        $date_param = $request->query('date');

        if (!$date_param) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Параметр date обязателен',
                'data' => new \stdClass(),
            ], 400);
        }

        $positions = TopCategoryPosition::where('date', $date_param)
            ->get(['category', 'position'])
            ->keyBy('category')
            ->map(function ($position_item) {
                return $position_item->position;
            });

        return response()->json([
            'status_code' => 200,
            'message' => 'ok',
            'data' => $positions,
        ]);
    }
}
