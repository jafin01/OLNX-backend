<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(Request $request) {
        if (auth()->user()->is_admin) {
            $data['playgrounds'] = Conversation::where('template', false)->count();
        $data['templates'] = Conversation::where('template', true)->count();
        $data['users'] = User::count();
        return $data;
        } else {
            return response([
                'message' => 'UnAuthorized'
            ], 401);
        }
    }
}
