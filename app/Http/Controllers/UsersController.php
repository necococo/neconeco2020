<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; 

class UsersController extends Controller
// create,storeはRegisterControllerがやってくれている

{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(50);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
   
    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(20);
        $data = ['user' => $user,'microposts' => $microposts];
        $data += $this->counts($user);

        return view('users.show', $data);
    }
   
    //ユーザー情報　編集    
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);
    }
    
    public function update(Request $request)
    {   
        $user = \Auth::User();
        $user->name = $request->name;
        // $user->email= $request->email;
        $user->save();
        return back()->with(['user' => $user, 'user_updated'=> 'ユーザーデータは更新されました。']);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/');
    }


    
// followings,followersアクション  
    
// 'user' => $user(操作者), 'users' => $followings(フォローしてる人たち)とその数のデータ変数を作ってviewに渡している  
//followingsとfollowersをまとめてusers.users.blade.phpで表示しているためusersという名前で渡して、$usersでviewで受け取っている。

    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(50);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }
    
    //'user' => $user(操作者), 'users' => $followers(フォロワーさんたち)とその数のデータ変数を作ってviewに渡している  

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(50);
        
        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    
    // public function favoritings(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if( !empty($request->sort) ){
    //         $user->fovo_photos_order = $request->sort ?: NULL;
    //         $user->save();
    //         //データを呼び出して更新する
    //     }
        
    //     //print_r($request->sort);
        
    //     $favoritings = $user->favoritings()->paginate(5);
    //     //$result_arr = unserialize($result_arr);
        
    //     $data = [
    //         'user' => $user,
    //         'favoritings' => $favoritings,
    //         'result_arr' =>  $user->fovo_photos_order,
    //         'count' => $this->counts($user)
    //     ];
    //     //$data += $this->counts($user);
        
    //     dd($data);
        
    //     return view('users.favoritings', $data);
    // }
    
    public function favoritings($id)
    {
        $user = User::find($id);
        $favoritings = $user->favoritings()->orderBy('created_at', 'desc')->paginate(20);
        
        $data = [
            'user' => $user,
            'favoritings' => $favoritings,
        ];
        
        $data += $this->counts($user);
        
        return view('users.favoritings', $data);
    }
}


