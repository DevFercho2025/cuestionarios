<?php

namespace App\Http\Controllers;


use App\Models\SubArea;
use Illuminate\Support\Facades\Auth;
//se Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $companyId = $user->config->Company->id;

        $subareas = SubArea::with('areas')
            ->withCount(['positionPosts' => function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            }])
            ->where('company_id', $companyId)
            ->get();

        return view('admin.index', compact('user', 'subareas'));
    }
}
