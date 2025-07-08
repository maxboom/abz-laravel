<?php

namespace App\Http\Controllers\Api\V1;

class PositionController
{
    public function index()
    {
        $positions = Position::all(['id', 'name']);

        return response()->json([
            'success' => true,
            'positions' => $positions,
        ]);
    }
}
