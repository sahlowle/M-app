<?php

namespace App\Http\Controllers\Api\Customer;

use App\Events\SendMessage;
use App\Events\SendMessageToAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CustomerStoreMessageRequest;
use App\Http\Requests\Api\Admin\AdminUpdateMessageRequest;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\CustomerNotification;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerMessageController extends Controller
{
    // public function getAllConversation(Request $request)
    // {
    //     $customer = $request->user();

    //     $per_page = $request->get('per_page',$this->default_per_page);

    //     $data = Conversation::with('customer:id,name','latestMessage')
    //     ->where('customer_id',$customer->id)
    //     ->latest('id')
    //     ->paginate($per_page);

    //     return $this->sendResponse(true,$data,'data retrieved successful',200);
    // }

    public function getConversationChats(Request $request)
    {
        $customer = $request->user();

        $conversation = $customer->conversations()->first();

        if (is_null($conversation)) {
            return $this->sendResponse(true ,[] ,"data not found ",200);
        }

        $per_page = $request->get('per_page',$this->default_per_page);

        $data = $conversation->messages()->latest('id')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }


    public function sendMessage(CustomerStoreMessageRequest $request)
    {
        $customer = $request->user();

        $conversation = Conversation::where('customer_id',$customer->id)->first();

        if (is_null($conversation)) {
            $conversation = Conversation::create([
                'customer_id' => $customer->id
            ]);
        }

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $customer->id,
            'sender_type' => 'customer',
            'message' => $request->message
        ];

        $message = Message::create($data);

        $admin_id = User::first()->id;

        event(new SendMessageToAdmin($customer->id,$data));
       
       return $this->sendResponse(true , $message , 'message created successful',200);
    }

 
    public function updateMessage(AdminUpdateMessageRequest $request, $id)
    {
        $message = Message::find($id);

        if (is_null($message)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $customer_id = $request->user()->id;

        if ($message->sender_id != 'customer'  && $message->sender_id != $customer_id) {
            abort(403);
        }

        $data = $request->validated();

        $message->update($data);

        return $this->sendResponse(true,$message,'message updated successful',200);
    }


    public function deleteMessage(Request $request,$id)
    {
        $message = Message::find($id);

        if (is_null($message)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $customer_id = $request->user()->id;

        if ($message->sender_id != 'customer'  && $message->sender_id != $customer_id) {
            abort(403);
        }

        $message->delete();

        return $this->sendResponse(true,$message,'message deleted successful',200);
    }

    public function getNotifications(Request $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = CustomerNotification::select(['title','body'])->latest('id')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }
}
