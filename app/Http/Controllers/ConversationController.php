<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function save(Request $request) {

        // return $request->all();
        $conversation = new Conversation();
        // get name from OpenAI for this conversation here
        if ($request->name) {
            $conversation->name = $request->name;
        } else {
            // put the generated name here
        }
        $conversation->user_id = auth()->user()->id;
        $conversation->system_1 = $request->config1['system'];
        $conversation->system_2 = $request->config2['system'];
        if ($request->template) {
            $conversation->template = true;
        }
        $conversation->save();

        // loop through all request messages
        foreach ($request->messages as $message) {
            $msg = new Message();
            $msg->conversation_id = $conversation['id'];
            $msg->message = $message['message'];
            $msg->sender = $message['role'];
            $msg->save();
        }

        // a function that saves all configs
        $config = new Config();
        $config->conversation_id = $conversation->id;
        $config->model_1 = $request->config1['model'];
        $config->model_2 = $request->config2['model'];
        $config->temperature_1 = $request->config1['temperature'];
        $config->temperature_2 = $request->config2['temperature'];
        $config->top_p_1 = $request->config1['top_p'];
        $config->top_p_2 = $request->config2['top_p'];
        $config->frequency_penalty_1 = $request->config1['frequency_penalty'];
        $config->frequency_penalty_2 = $request->config2['frequency_penalty'];
        $config->presence_penalty_1 = $request->config1['presence_penalty'];
        $config->presence_penalty_2 = $request->config2['presence_penalty'];
        $config->max_length_1 = $request->config1['maxLength'];
        $config->max_length_2 = $request->config2['maxLength'];
        $config->save();

        return $conversation;
    }

    public function chat(Request $request) {
        return $request->all();
    }

    public function index() {
        $conversation = Conversation::where('user_id', auth()->user()->id)->where('template', false)->get();
        return $conversation;
    }

    public function templates() {
        $conversation = Conversation::where('user_id', auth()->user()->id)->where('template', true)->get();
        return $conversation;
    }

    public function show($id) {
        $data['conversation'] = Conversation::where('id', $id)->first();
        if ($data['conversation']->template || $data['conversation']->user_id == auth()->user()->id) {
            $data['messages'] = Message::where('conversation_id', $id)->get();
            $data['config'] = Config::where('conversation_id', $id)->first();
            return $data;
        } else {
            return response([
                'message' => 'UnAuthorized'
            ], 401);
        }
    }
}
