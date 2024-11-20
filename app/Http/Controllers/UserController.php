<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function TicketStore(TicketRequest $request)
    {
        
        // Get the authenticated user
        $user = Auth::user();
        if ($request->hasFile('image')) {
            // Get the original image name
            $imageName = $request->file('image')->getClientOriginalName();
    
            // Store the image in the 'tickets' folder in public storage without hashing the name
            $request->file('image')->storeAs('tickets', $imageName, 'public');
        } else {
            // If no image is uploaded, set image to null
            $imageName = null;
        }

        // Store the ticket and associate it with the user
        $ticket = Ticket::create([
            'user_id' => $user->id, // Associate the ticket with the authenticated user
            'issue' => $request->issue, // The ticket issue provided by the user
            'priority' => $request->priority, // Optional priority
            'status' => $request->status ?? 'pending', // Default to 'pending' if not provided
            'feedback' => $request->feedback, // Optional feedback
            'image' => $imageName, // Store image if provided
        ]);

        // Return the created ticket as response
        return response()->json([
            'message' => 'Ticket created successfully.',
            'ticket' => $ticket // Optionally, you can return the created ticket data
        ], 201); // HTTP Status Code 201: Created
    }

    public function TicketIndex()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch tickets for the authenticated user
        $tickets = Ticket::where('user_id', $user->id)->get();

        // Return the tickets in a JSON response
        return response()->json([
            'tickets' => $tickets
        ], 200); // HTTP Status Code 200: OK
    }
}
