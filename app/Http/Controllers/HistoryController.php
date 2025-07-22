<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        return view('history.index');
    }

    public function datatable(Request $request)
    {

        $companyUser = Auth::user();
        $isSuperAdmin = $companyUser->config->role->isSuperAdmin() ?? false;
        $companyId =  $companyUser->config->company_id;

        $query = History::with(['user','user.config.company']);

         if (!$isSuperAdmin) {
            $query->whereHas('user.config.company', function ($q) use ($companyId) {
                $q->where('id', $companyId);
            });
        }

        $history = $query->get();

        $data = $history->map(function ($h) use ($isSuperAdmin) {
            return [
                'id' => $h->id,
                'user_id' => $h->user_id,
                'user_name' => $h->user->name,
                'comment' => $h->comment,
                'company_name' => $isSuperAdmin ? ($h->user->config->company->name ?? 'Sin compañía') 
                : null,
            ];
        });

        return response()->json($data);
    }
}
