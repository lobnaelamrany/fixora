@extends('layouts.fixora')

@section('title', 'Admin Dashboard — FIXORA')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-fixora-teal">Admin Dashboard</h1>
            <p class="text-fixora-gray-600 mt-1">Platform overview and management.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg border border-fixora-gray-200 p-6">
                <p class="text-sm text-fixora-gray-500 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-fixora-teal">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="bg-white rounded-lg border border-fixora-gray-200 p-6">
                <p class="text-sm text-fixora-gray-500 mb-1">Professionals</p>
                <p class="text-3xl font-bold text-fixora-emerald">
                    {{ \App\Models\User::where('role', 'professional')->count() }}
                </p>
            </div>
            <div class="bg-white rounded-lg border border-fixora-gray-200 p-6">
                <p class="text-sm text-fixora-gray-500 mb-1">Total Requests</p>
                <p class="text-3xl font-bold text-fixora-amber">{{ \App\Models\ServiceRequest::count() }}</p>
            </div>
            <div class="bg-white rounded-lg border border-fixora-gray-200 p-6">
                <p class="text-sm text-fixora-gray-500 mb-1">Categories</p>
                <p class="text-3xl font-bold text-fixora-teal">{{ \App\Models\ServiceCategory::count() }}</p>
            </div>
        </div>
    </div>
@endsection
