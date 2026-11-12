<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation): RedirectResponse
    {
        $user = $request->user();

        $isCustomer = $conversation->customer_id === $user->id;
        $isProvider = $conversation->providerProfile?->user_id === $user->id;
        abort_unless($isCustomer || $isProvider, 403);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message_type' => 'text',
            'body' => $data['body'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()
            ->route('conversations.show', $conversation)
            ->with('success', 'Message sent.');
    }
}
