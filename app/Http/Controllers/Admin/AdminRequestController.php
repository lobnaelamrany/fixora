<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('q');

        $query = ServiceRequest::with(['customer', 'providerProfile.user', 'serviceCategory'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                  ->orWhere('service_title', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(15);

        return view('admin.requests.index', compact('requests', 'status', 'search'));
    }
}
