<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function save(Request $request) {
        $conversation = new Conversation();
        // get name from OpenAI for this conversation here
        if ($request->name) {
            $conversation->name = $request->name;
        } else {
            $conversation->name = 'test conversation';
            // return 'no name';
            // put the generated name here
        }
    $conversation->user_id = auth()->user()->id;
        if ($request->template) {
            $conversation->template = true;
        } else {
            $conversation->template = false;
        }
        try {
            $conversation->save();   
        } catch(\Exception $e) {
            return [
                "error"=> "Helloo"
            ];
        }
        try {
            foreach ($request->messages as $message) {
                $msg = new Message();
                $msg->user_id = auth()->user()->id;
                $msg->conversation_id = $conversation->id;
                $msg->message = $message['message'];
                $msg->role = $message['role'];

                $msg->save();
            }
        } catch(\Exception $e) {
            error_log($e->getMessage());
            return [
                "error" => "An error occurred while saving the message."
            ];
        }
        
        try{
            foreach ($request->configs as $config) {
                $configuration = new Config();
                $configuration->conversation_id = $conversation->id;
                $configuration->user_id = auth()->user()->id;
                $configuration->name = $config["name"];
                $configuration->system = $config["system"];
                $configuration->model = $config['model'];
                $configuration->top_p = $config['top_p'];
                $configuration->temperature = $config['temperature'];
                $configuration->maxLength = $config['maxLength'];
                $configuration->frequency_penalty = $config['frequency_penalty'];
                $configuration->presence_penalty = $config['presence_penalty'];
                $configuration->save();
                // $this->saveMessages($request->messages[$index], $conversation, $configuration);
            }

        } catch(\Exception $e) {
            error_log($e->getMessage());
            return [
                "error" => "An error occurred while saving the message."
            ];
        }

        return $conversation;
    }

    // UPDATE CONVERSATION
    public function update(Request $request) {

       try { 
        $conversation = Conversation::find($request->id);

        $conversationId = $request->id;

        if (!$conversation) {
            // Conversation not found
            return response()->json([
                'error' => 'Conversation not found.'
            ], 410);
        }

        if ($request->name) {
            $conversation->name = $request->name;
        } else {
            // Generate and set the conversation name here
            $conversation->name = "test updated";
            error_log("generated a new name");
        }

        // Update conversation name
        $conversation->user_id = auth()->user()->id;

        if ($request->template) {
            $conversation->template = true;
        } else {
            $conversation->template = false;
        }

        try {
            $conversation->save();   
        } catch(\Exception $e) {
            return [
            "error"=> "An error occurred while saving the conversation."
            ];
        }

        try {
            // Delete existing messages
            Message::where('conversation_id', $conversation->id)->delete();
            
            // Save updated messages
            foreach ($request->messages as $message) {
                $msg = new Message();
                $msg->user_id = auth()->user()->id;
                $msg->conversation_id = $conversation->id;
                $msg->message = $message['message'];
                $msg->role = $message['role'];
                $msg->save();
            }
        } catch(\Exception $e) {
            return [
                "error" => "An error occurred while saving the messages."
            ];
        }

        try {
            // Delete existing configurations
            Config::where('conversation_id', $conversation->id)->delete();

            // Save updated configurations

            foreach ($request->configs as $config) {
                $configuration = new Config();
                $configuration->conversation_id = $conversation->id;
                $configuration->user_id = auth()->user()->id;
                $configuration->name= $config["name"];
                $configuration->system = $config["system"];
                $configuration->model = $config['model'];
                $configuration->top_p = $config['top_p'];
                $configuration->temperature = $config['temperature'];
                $configuration->maxLength = $config['maxLength'];
                $configuration->frequency_penalty = $config['frequency_penalty'];
                $configuration->presence_penalty = $config['presence_penalty'];
                $configuration->save();
            }
        } catch(\Exception $e) {
            error_log($e->getMessage());
            return [
                "error" => "An error occurred while saving the configurations."
            ];
        }

        return $conversation;
        } catch (\Exception $e) {
            // Log the error for debugging
            error_log($e->getMessage());
            
            // Return an error response
            return response()->json([
                'error' => 'An internal server error occurred. Please try again later.'
            ], 500);
        }
    }

    public function chat(Request $request) {
        return $request->all();
    }

    // get conversations...
    public function index() {
        $conversation = Conversation::where('user_id', auth()->user()->id)->where('template', false)->get();
        return $conversation;
    }

    // get templates
    public function templates() {
        $conversation = Conversation::where('user_id', auth()->user()->id)->where('template', true)->get();
        return $conversation;
    }

    public function show($id) {
        error_log('Conversation ID: ' . $id);
        $data['conversation'] = Conversation::where('id', $id)->first();
        if ($data['conversation']->template || $data['conversation']->user_id == auth()->user()->id) {
            $data['messages'] = Message::where('conversation_id', $id)->get();
            $data['configs'] = Config::where('conversation_id', $id)->get();

            error_log($data['configs']);
            return $data;
        } else {
            return response([
                'message' => 'UnAuthorized'
            ], 401);
        }
    }
}


