<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $role = $request->query('role', 'all');
        $search = $request->query('q');

        $query = User::query()->latest();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function show(User $user): View
    {
        $user->load(['providerProfile.services', 'providerProfile.areas', 'serviceRequests']);

        return view('admin.users.show', compact('user'));
    }

    public function suspend(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403, 'Cannot suspend an admin.');

        $user->update(['account_status' => 'suspended']);

        return back()->with('success', "User {$user->name} suspended.");
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['account_status' => 'active']);

        return back()->with('success', "User {$user->name} activated.");
    }
}
