<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = Conversation::query()
            ->with(['serviceRequest.serviceCategory', 'customer', 'providerProfile.user'])
            ->latest('last_message_at')
            ->latest();

        if ($user->isCustomer()) {
            $query->where('customer_id', $user->id);
        } elseif ($user->isProfessional()) {
            $profile = $user->providerProfile;
            if (!$profile) {
                return view('conversations.index', ['conversations' => collect()]);
            }
            $query->where('provider_profile_id', $profile->id);
        } else {
            abort(403);
        }

        $conversations = $query->paginate(15);

        return view('conversations.index', compact('conversations'));
    }

    public function show(Request $request, Conversation $conversation): View
    {
        $this->authorizeConversation($request->user(), $conversation);

        $conversation->load([
            'serviceRequest.serviceCategory',
            'customer',
            'providerProfile.user',
            'messages.sender',
        ]);

        $conversation->messages()
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('conversations.show', compact('conversation'));
    }

    private function authorizeConversation($user, Conversation $conversation): void
    {
        $isCustomer = $conversation->customer_id === $user->id;
        $isProvider = $conversation->providerProfile?->user_id === $user->id;

        abort_unless($isCustomer || $isProvider, 403, 'Unauthorized.');
    }
}
