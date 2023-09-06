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

    
    // public function sendUserChat(Request $request)
    // {
    //     // Validate the input
    //     $request->validate([
    //         'message' => 'required|string',
    //     ]);
    
    //     // Save the chat message to the database
    //     $message = $request->input('message');
    //     $recipient = $request->input('sender_id');
    //     $type = $request->input('type');
    //     $user = $request->user(); // Assuming you have user authentication configured
    //     $chatMessage = ChatMessage::create([
    //         'user_id' => $user->id,
    //         'sender_id' => $recipient,
    //         'message' => $message,
    //         'type' => $type,
    //     ]);
    
    //     // Send the chat message to the recipient in real-time using Pusher
    //     $pusher = new Pusher(
    //         config('broadcasting.connections.pusher.key'),
    //         config('broadcasting.connections.pusher.secret'),
    //         config('broadcasting.connections.pusher.app_id'),
    //         [
    //             'cluster' => config('broadcasting.connections.pusher.options.cluster'),
    //             'useTLS' => true,
    //         ]
    //     );
    
    //     $pusher->trigger("chat-channel-{$recipient}", 'new-message', $chatMessage);
    
    //     return response()->json([
    //         'success' => true,
    //         'data' => $chatMessage,
    //     ], 200);
    // }






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
    $offer = $request->input('offer');
    $user = $request->user(); // Assuming you have user authentication configured
    $chatMessage = ChatMessage::create([
        'user_id' => $user->id,
        'sender_id' => $recipient,
        'message' => $message,
        'type' => $type,
        'offer' => $offer,
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

    // Mark previously unseen messages as seen
    ChatMessage::where('user_id', $recipient)
        ->where('sender_id', $user->id)
        ->where('seen', false)
        ->update(['seen' => true]);

    return response()->json([
        'success' => true,
        'data' => $chatMessage,
    ], 200);
}




// public function messageShow(Request $request)
// {
//     $recipient = $request->input('sender_id');
//     $user = $request->user(); // Assuming you have user authentication configured
//     $userChats = ChatMessage::where(function ($query) use ($user, $recipient) {
//         $query->where('user_id', $user->id)
//             ->where('sender_id', $recipient);
//     })->orWhere(function ($query) use ($user, $recipient) {
//         $query->where('user_id', $recipient)
//             ->where('sender_id', $user->id);
//     })->get();

//     // Update the status of each unseen message to "seen"
//     $userChats->where('user_id', $user->id)
//         ->where('sender_id', $recipient)
//         ->where('seen', false)
//         ->each(function ($message) {
//             $message->seen = true;
//             $message->save();
//         });

//     return response()->json([
//         'success' => true,
//         'data' => $userChats,
//     ], 200);
// }

public function messageShow(Request $request)
{
    $recipient = $request->input('sender_id');
    $user = $request->user(); // Assuming you have user authentication configured

    // Retrieve chat messages between the current user and the recipient
    $userChats = ChatMessage::where(function ($query) use ($user, $recipient) {
        $query->where('user_id', $user->id)
            ->where('sender_id', $recipient);
    })->orWhere(function ($query) use ($user, $recipient) {
        $query->where('user_id', $recipient)
            ->where('sender_id', $user->id);
    })->get();

    // Update the status of each unseen message to "seen" for the current user
    $userChats->where('user_id', $user->id)
        ->where('sender_id', $recipient)
        ->where('seen', false)
        ->each(function ($message) {
            $message->seen = true;
            $message->save();
        });

    // Update the status of each unseen message to "seen" for the recipient
    $userChats->where('user_id', $recipient)
        ->where('sender_id', $user->id)
        ->where('seen', false)
        ->each(function ($message) {
            $message->seen = true;
            $message->save();
        });

        $userChats->transform(function ($message) {
            $message->offer = json_decode($message->offer);
            return $message;
        });

    return response()->json([
        'success' => true,
        'data' => $userChats,
    ], 200);
}
   



// public function AllUser(Request $request)
// {
//     $user = $request->user();
//     $users = User::select('id', 'name', 'last_name', 'image')
//         ->withCount(['unseenMessages as unseen_message_count' => function ($query) use ($user) {
//             $query->where('sender_id', $user->id)
//                 ->where('seen', false);
//         }])
//         ->orderBy('unseen_message_count', 'desc')
//         ->get();

//     return response()->json([
//         'success' => true,
//         'message' => 'All Data successfully',
//         'data' => $users,
//     ], 200);
// }

// public function AllUser(Request $request)
// {
//     $user = $request->user();

//     // Retrieve the IDs of users with whom the current user has chatted
//     $chattedUserIds = ChatMessage::where('user_id', $user->id)
//         ->orWhere('sender_id', $user->id)
//         ->pluck('user_id', 'sender_id')
//         ->flatten()
//         ->unique();

//     // Retrieve the users who have chatted with the current user
//     $users = User::whereIn('id', $chattedUserIds)
//         ->select('id', 'name', 'last_name', 'image')
//         ->withCount(['unseenMessages as unseen_message_count' => function ($query) use ($user) {
//             $query->where('sender_id', $user->id)
//                 ->where('seen', false);
//         }])
//         ->orderBy('unseen_message_count', 'desc')
//         ->get();

//     return response()->json([
//         'success' => true,
//         'message' => 'All Data successfully',
//         'data' => $users,
//     ], 200);
// }

// public function AllUser(Request $request)
// {
//     $user = $request->user();

//     // Retrieve the IDs of users who have sent messages to the current user
//     $senderIds = ChatMessage::where('user_id', $user->id)
//         ->pluck('sender_id')
//         ->unique();

//     // Retrieve the IDs of users who have received messages from the current user
//     $recipientIds = ChatMessage::where('sender_id', $user->id)
//         ->pluck('user_id')
//         ->unique();

//     // Combine both sender IDs and recipient IDs
//     $chattedUserIds = $senderIds->concat($recipientIds)->unique();

//     // Retrieve the users who have chatted with the current user
//     $users = User::whereIn('id', $chattedUserIds)
//         ->select('id', 'name', 'last_name', 'image')
//         ->withCount(['unseenMessages as unseen_message_count' => function ($query) use ($user) {
//             $query->where('sender_id', $user->id)
//                 ->where('seen', false);
//         }])
//         ->orderBy('unseen_message_count', 'desc')
//         ->get();

//     return response()->json([
//         'success' => true,
//         'message' => 'All Data successfully',
//         'data' => $users,
//     ], 200);
// }
public function AllUser(Request $request)
{
    $user = $request->user();
    // Retrieve the IDs of users who have sent messages to or received messages from the current user
    $chattedUserIds = ChatMessage::where('user_id', $user->id)
        ->orWhere('sender_id', $user->id)
        ->pluck('user_id')
        ->concat(ChatMessage::where('user_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->pluck('sender_id'))
        ->unique();

    // Retrieve the users who have chatted with the current user (excluding the current user)
    $users = User::whereIn('id', $chattedUserIds)
        ->where('id', '!=', $user->id)
        ->select('id', 'name', 'last_name', 'image')
        ->withCount(['unseenMessages as unseen_message_count' => function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('seen', false);
        }])
        ->orderByDesc(function ($query) use ($user) {
            $query->select('created_at')
                ->from('chat_messages')
                ->whereColumn('users.id', 'chat_messages.user_id')
                ->orWhereColumn('users.id', 'chat_messages.sender_id')
                ->orderBy('created_at', 'desc')
                ->limit(1);
        })
        ->orderBy('unseen_message_count', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'User list retrieved successfully',
        'data' => $users,
    ], 200);
}









public function updateSeen($id)
{
    $course = ChatMessage::where('id', $id)->first();
    if (is_null($course)) {
        return response()->json([
            'success' => false,
            'message' => 'Course not found'
        ], 404);
    }
    // Update the 'seen' column to true
    $course->seen = true;
    $course->save();

    return response()->json([
        'success' => true,
    ], 200);
}





}
 