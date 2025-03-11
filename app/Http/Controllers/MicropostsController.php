<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Storage;
use Validator;
use Image;
use App\Micropost;
use App\User;
use App\Comment;

class MicropostsController extends Controller
{
    public function index()
    {
        
        if (\Auth::check()) {
            $microposts = DB::table('microposts')->orderBy('created_at', 'desc')->paginate(20);
            return view('microposts.index', ['microposts' => $microposts]);
        }else {
            $microposts = DB::table('microposts')->orderBy('created_at', 'desc')->paginate(10);
            return view('welcome', ['microposts' => $microposts]);
        }
    }


    public function show($id)
    {
        $user = \Auth::user();
        $micropost = Micropost::find($id);
        // $json_micropost = $micropost->toJson();
        $json_micropost = json_encode($micropost);
        //なんかエラーが出るときがあったのでif文にした
        if($micropost->comments()) {
            $comments = $micropost->comments()->orderBy('created_at', 'DESC')->get();
            $data = ['user' => $user, 'micropost' => $micropost, 'comments'=>$comments, 'json_micropost'=>$json_micropost];
        }else {
            $data = ['user' => $user,'micropost' => $micropost,'json_micropost'=>$json_micropost];
        }
        
        return view('microposts.show',$data);
    }
    
      //編集    
    public function edit($id)
    {
        $data = [];
        $user = \Auth::user();
        $micropost = Micropost::find($id);
   
        // dd($micropost->map_lng);
        $comments = $micropost->comments()->orderBy('created_at', 'DESC')->get();
        $data = ['user' => $user, 'micropost' => $micropost, 'comments'=>$comments];
        return view('microposts.edit',$data);
        
    }
    
    public function update(Request $request, $id)
    {   
        $data = [];
        $validator = Validator::make($request->all(),[
        // 'file' => 'required|image|max:5120',
        'search_tag' => 'nullable',
        // 'lat' => 'required',
        // 'lng' => 'required',
        ]);
        
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        
        $user = \Auth::user();
        $micropost = Micropost::find($id);
        $micropost->search_tag = $request->search_tag;
        $micropost->save();
        // $json_micropost = $micropost->toJson();
        $json_micropost = json_encode($micropost);
        $comments = $micropost->comments()->orderBy('created_at', 'desc')->get();
        
        
        $data = ['user' => $user, 'micropost' => $micropost, 'comments'=>$comments];
        return view('microposts.show', $data, ['json_micropost'=>$json_micropost])->with('updated','データは更新されました。');
    }
    
    public function create()
    {
        
        $data = [];
        $user = \Auth::user();
        $microposts = $user->microposts();
        $data = ['user' => $user, 'microposts' => $microposts];
        $data += $this->counts($user);
        
        return view('microposts.create',$data);
    }
    
    
    
    public function store(Request $request)
    {
        //先にファイルの種類とサイズをチェック
        $validator = Validator::make($request->all(),[
        'file' => 'required|image|max:5120',
        ]);
        
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        
        //ファイルが写真ならば、apiに写真をアップし猫かどうかの判定、猫でなければもう一度アップ画面に遷移、猫なら保存
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://aimaker.io/image/classification/api",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'id' => 5629,
                //公開されているキーなので隠さなくて良い
                'apikey' => "c28f3694803e7631c5feb0831f29be77a0a03197bec8f9d55204f77db57bd7dfb3a10fa3f7d3b0ddf229f1d62a648243",
                // , $_FILES["file"]["type"], $_FILES["file"]["name"]を入れないとエラー
                'file' => new \CURLFile($_FILES["file"]["tmp_name"], $_FILES["file"]["type"], $_FILES["file"]["name"]),
            ],
            CURLOPT_HTTPHEADER => ['Content-Type:multipart/form-data'],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        
        $result = curl_exec($ch);
        $response = json_decode($result, true);
        // dd($response);
        //array:3 [▼
        //   "url" => "https://aimaker.io/uptmp/d1b2e9c614f8a1c3017d4f63c8d99a534fe30d5f.jpg"
        //   "labels" => array:2 [▼
        //     0 => array:2 [▼
        //       "score" => 0.999
        //       "label" => "猫"
        //     ]
        //     1 => array:2 [▼
        //       "score" => 0.001
        //       "label" => "犬"
        //     ]
        //   ]
        //   "state" => 1
        // ]
        curl_close($ch);
        //判定が猫かどうかのboolian変数
        $is_cat = $response['labels']['0']['score'] >= 0.65 ;
        // dd($request);
        //    +request: ParameterBag {#44 ▼
        //     #parameters: array:4 [▼
        //       "_token" => "psOE2ZlZ06AqRzVA06QPQg168JnWzrx5KcALvRE3"
        //       "search_tag" => null
        //       "lat" => "34.045952"
        //       "lng" => "131.0687232"
        //     ]
        //   }
        
        
        //↓　user_idは自動付加
        // 'user_id' => $request->user()->id,
        //
        // 'image_path' => $request->file('file'),
        //"image_path" => UploadedFile {#244 ▼
        //   -test: false
        //   -originalName: "519_1-740x493.jpg"
        //   -mimeType: "image/jpeg"
        //   -size: 38389
        //   -error: 0
        //   #hashName: null
        //   path: "/tmp"
        //   filename: "phpQCONvi"
        //   basename: "phpQCONvi"
        //   pathname: "/tmp/phpQCONvi"
        //   extension: ""
        //   realPath: "/tmp/phpQCONvi"
        //   aTime: 2020-11-13 11:10:33
        //   mTime: 2020-11-13 11:10:33
        //   cTime: 2020-11-13 11:10:33
        //   inode: 348099
        //   size: 38389
        //   perms: 0100600
        //   owner: 501
        //   group: 501
        //   type: "file"
        //   writable: true
        //   readable: true
        //   executable: false
        //   file: true
        //   dir: false
        //   link: false
        // }
        
        if($is_cat) {
            // s3/images/にアップ
            $path = Storage::disk('s3')->putFile('neconeco2020/images', $request->file('file'), 'public'); 
            //生成されたs3上のURLを変数に代入
            $url = Storage::disk('s3')->url($path);
            
            $micropost = $request->user()->microposts()->create([
                'search_tag' => $request->search_tag,
                'map_lat' => $request->lat,
                'map_lng' => $request->lng,
                'image_path' => $url
            ]);
            //↑ここでHeroku でエラー　->どの方法でもセーブができず-> heroku pg:reset DATABASE -> heroku run php artisan migrate
            // $micropost = new Micropost;
            // $micropost->search_tag = $request->search_tag;
            // $micropost->map_lat = $request->lat;
            // $micropost->map_lng = $request->lng;
            // $micropost->image_path = $url;
            // $micropost->save();
            // dd($micropost);
            //新規なので空のはず
            // $comments = $micropost->comments()->orderBy('created_at', 'desc')->get();
            
            // return view('microposts.show', ['micropost' =>$micropost, 'comments'=>$comments ])->with('success','ファイルはアップロードされました。');
            // return redirect()->route('microposts.show', ['micropost' =>$micropost, 'comments'=>$comments ])->with('success','ファイルはアップロードされました。');
            return redirect()->route('microposts.show', ['micropost' =>$micropost])->with('success','ファイルはアップロードされました。');
        }else {
            $cat_error = "この写真はおそらく猫ではありませんね。猫写真をアップしてください。";

            return redirect()->back()->with('cat_error',$cat_error);
        }
    }
    

    public function destroy($id)
    { 
        $micropost = Micropost::find($id);
        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }
        return redirect('/');
    }  
    
    
    public function search(Request $request)
    { 
        //dd($request);
        $keywords = [];
        $keywords = explode(",", $request->search_words);
        // キーワードの数だけループし、LIKE句の配列を作る
        $keywordCondition = [];
        foreach ($keywords as $keyword) {
            $keywordCondition[] = 'search_tag LIKE \'%' . $keyword . '%\'';
        }
        //"search_tag LIKE '%%'"
        // ここで、 
        // [ "search_tag LIKE '%hoge%'", 
        //   "search_tag LIKE '%piyo%'"]
        // という配列ができあがっている。
        
        // これをORでつなげて、文字列にする
        $keywordCondition = implode(' OR ', $keywordCondition);
        $sql = DB::table('microposts')->whereRaw($keywordCondition)->orderBy('created_at', 'desc')->paginate(8);
       
        return view('microposts.search', ['sql' => $sql]);
    }
    
    public function all_map()
    {
        $microposts = DB::table('microposts')->get();
        //<script></script>へ渡すためにjson形式へ変換
        // $microposts = $microposts->toJson();
        $microposts = json_encode($microposts);

        // dd($microposts);
        return view('microposts.all_map', ['microposts' => $microposts]);
    }
   
}