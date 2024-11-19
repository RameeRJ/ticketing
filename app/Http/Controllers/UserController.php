<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Http\Requests\TicketRequest;

class UserController extends Controller
{
    public function TicketStore(TicketRequest $request)
    {
        // Create a new ticket using the validated request data
        Ticket::create([
            'issue' => $request->issue, // Assuming the validated field is 'issue'
            'priority' => $request->priority, // Optional
            'status' => $request->status ?? 'pending', // Default to 'pending' if not provided
            'feedback' => $request->feedback, // Optional
            'image' => $request->file('image')?->store('tickets', 'public'), // Store image if provided
        ]);

        return response()->json(['message' => 'Ticket created successfully.']);
    }
}
