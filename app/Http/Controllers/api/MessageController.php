<?php

namespace App\Http\Controllers\api;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\BanksPayment;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
   
    public function index()
    {
        $Payment = BanksPayment::get();
        if (is_null($Payment)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'All Data susccessfull',
            'data' => $Payment,
        ]);
    }


    public function sendMessage(Request $request)
    {
        // Validate the input
        $request->validate([
            'message' => 'required|string',
        ]);
    
        // Save the chat message to the database
        $message = $request->input('message');  
        $user = $request->user(); // Assuming you have user authentication configured
        $chatMessage = ChatMessage::create([
            'message' => $message,
            // 'user_id' => $user->id,
        ]);
    
        // Send the chat message to other users in real-time using Pusher
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true,
            ]
        );
    
        $pusher->trigger('chat-channel', 'new-message', $chatMessage);
    
        return response()->json([
            'success' => true,
            'data' => $chatMessage, // Return the chat message object
        ], 200);
    }

    
    public function sendUserChat(Request $request)
    {
        // Validate the input
        $request->validate([
            'message' => 'required|string',
        ]);
    
        // Save the chat message to the database
        $message = $request->input('message');
        $recipient = $request->input('sender_id');
        $type = $request->input('type');
        $user = $request->user(); // Assuming you have user authentication configured
        $chatMessage = ChatMessage::create([
            'user_id' => $user->id,
            'sender_id' => $recipient,
            'message' => $message,
            'type' => $type,
        ]);
    
        // Send the chat message to the recipient in real-time using Pusher
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true,
            ]
        );
    
        $pusher->trigger("chat-channel-{$recipient}", 'new-message', $chatMessage);
    
        return response()->json([
            'success' => true,
            'data' => $chatMessage,
        ], 200);
    }


    public function messageShow(Request $request)
    {
        $recipient = $request->input('sender_id');
        $user = $request->user(); // Assuming you have user authentication configured
        $userChats = ChatMessage::where(function ($query) use ($user, $recipient) {
            $query->where('user_id', $user->id)
                  ->where('sender_id', $recipient);
        })->orWhere(function ($query) use ($user, $recipient) {
            $query->where('user_id', $recipient)
                  ->where('sender_id', $user->id);
        })->get();
    
        return response()->json([
            'success' => true,
            'data' => $userChats,
        ], 200);
    }


//     public function deleteUserChats(Request $request, User $recipient)
// {
//     $user = $request->user(); // Assuming you have user authentication configured

//     // Delete the chat messages between the current user and the recipient
//     ChatMessage::where(function ($query) use ($user, $recipient) {
//         $query->where('user_id', $user->id)
//               ->where('sender_id', $recipient->id);
//     })->orWhere(function ($query) use ($user, $recipient) {
//         $query->where('user_id', $recipient->id)
//               ->where('sender_id', $user->id);
//     })->delete();

//     return response()->json([
//         'success' => true,
//         'message' => 'Chat messages deleted successfully.',
//     ], 200);
// }


}
 