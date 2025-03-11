<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Micropost;
use App\Comment;

class CommentsController extends Controller
{
    
   
    public function store(Request $request, $id)
    {
        $micropost = Micropost::find($id);
        $this->validate($request, ['comment' => 'required|max:191', ]);
        $micropost->comments()->create([
            'micropost_id' => $id,
            'user_id' => \Auth::User()->id,
            // 'user_name' => \Auth::User()->name,
            'comment' => $request->comment,
        ]);
        
        return redirect()->back();
    }
}
