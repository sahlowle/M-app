<?php

namespace App\Http\Controllers\Api\Admin;

use App\Events\SendMessageToCustomer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreMessageRequest;
use App\Http\Requests\Api\Admin\AdminUpdateMessageRequest;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{

    public function getAllConversation(Request $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Conversation::with('customer:id,name','latestMessage')->latest('id')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    public function getConversationChats(Request $request,$id)
    {
        $conversation = Conversation::find($id);

        if (is_null($conversation)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $per_page = $request->get('per_page',$this->default_per_page);

        $data = $conversation->messages()->latest('id')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }


    public function sendMessage(AdminStoreMessageRequest $request)
    {
        $conversation = Conversation::where('customer_id',$request->customer_id)->first();

        if (is_null($conversation)) {
            $conversation = Conversation::create($request->only('customer_id'));
        }

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $request->user()->id,
            'sender_type' => 'admin',
            'message' => $request->message
        ];

        $message = Message::create($data);

        $customer_id = $request->customer_id;

        // event(new SendMessageToCustomer($customer_id->id,$data));

       return $this->sendResponse(true , $message , 'message created successful',200);
    }


    public function updateMessage(AdminUpdateMessageRequest $request, $id)
    {
        $message = Message::find($id);

        if (is_null($message)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $admin_id = $request->user()->id;

        if ($message->sender_id != 'admin'  && $message->sender_id != $admin_id) {
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

        $admin_id = $request->user()->id;

        if ($message->sender_id != 'admin'  && $message->sender_id != $admin_id) {
            abort(403);
        }

        $message->delete();

        return $this->sendResponse(true,$message,'message deleted successful',200);
    }

}
