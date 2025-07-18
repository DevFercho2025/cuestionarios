<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        return view('history.index');
    }

    public function datatable(Request $request)
    {
        $history = History::with(['user'])->get();

        $data = $history->map(function ($h) {
            return [
                'id' => $h->id,
                'user_id' => $h->user_id,
                'user_name' => $h->user->name,
                'comment' => $h->comment,
            ];
        });

        return response()->json($data);
    }
}
