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
            $microposts = DB::table('microposts')->orderBy('created_at', 'desc')->paginate(8);
            return view('microposts.index', ['microposts' => $microposts]);
        }else {
            return view('welcome');
        }
    }
   

    public function show($id)
    {
        $user = \Auth::user();
        $micropost = Micropost::find($id);
        $json_micropost = $micropost->toJson();
        $comments = $micropost->comments()->orderBy('created_at', 'desc')->get();
        $data = ['user' => $user, 'micropost' => $micropost, 'comments'=>$comments];
        
        return view('microposts.show',$data, ['json_micropost'=>$json_micropost]);
    }
    
      //編集    
    public function edit($id)
    {
        $data = [];
        $user = \Auth::user();
        $micropost = Micropost::find($id);
   
        // dd($micropost->map_lng);
        $comments = $micropost->comments()->orderBy('created_at', 'desc')->get();
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
        $json_micropost = $micropost->toJson();
        $comments = $micropost->comments()->orderBy('created_at', 'desc')->get();
        $data = ['user' => $user, 'micropost' => $micropost, 'comments'=>$comments];
        return view('microposts.show', $data, ['json_micropost'=>$json_micropost])->with('updated','データは更新されました。');
    }
    
    public function create()
    {
        
        $data = [];
        $user = \Auth::user();
        $microposts =$user->microposts();
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
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //ファイルが写真ならば、apiに写真をアップし猫かどうかの判定、猫でなければもう一度アップ画面に遷移、猫なら保存
        // $ch = curl_init();
        // curl_setopt_array($ch, [
        //     CURLOPT_URL => "https://aimaker.io/image/classification/api",
        //     CURLOPT_POST => true,
        //     CURLOPT_POSTFIELDS => [
        //         'id' => 5629,
        //         //公開されているキーなので隠さなくて良い
        //         'apikey' => "c28f3694803e7631c5feb0831f29be77a0a03197bec8f9d55204f77db57bd7dfb3a10fa3f7d3b0ddf229f1d62a648243",
        //         // , $_FILES["file"]["type"], $_FILES["file"]["name"]を入れないとエラー
        //         'file' => new \CURLFile($_FILES["file"]["tmp_name"], $_FILES["file"]["type"], $_FILES["file"]["name"]),
        //     ],
        //     CURLOPT_HTTPHEADER => ['Content-Type:multipart/form-data'],
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLOPT_RETURNTRANSFER => true,
        // ]);
        
        // $result = curl_exec($ch);
        // $response = json_decode($result, true);
        // // print_r($response);
        // curl_close($ch);
        // //判定が猫かどうかのboolian変数
        // $is_cat = $response['labels']['0']['score'] >= 0.7;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        // if($is_cat) {
            $micropost = $request->user()->microposts()->create([
                // 'user_id' => $request->user()->id,
                'image_path' => $request->file('file'),
                'search_tag' => $request->search_tag,
                'map_lat' => $request->lat,
                'map_lng' => $request->lng,
            ]);
            // s3/images/にアップ
            $path = Storage::disk('s3')->putFile('neconeco2020', $request->file('file'), 'public'); 
            //生成されたs3上のURLを変数に代入
            $url = Storage::disk('s3')->url($path);
            $micropost->image_path = $url;
            $micropost->save();
            
            return redirect()->route('microposts.show', ['id' => $micropost->user_id, 'micropost' =>$micropost ])->with('success','ファイルはアップロードされました。');
        // }else {
        //     $cat_error = "この写真はおそらく猫ではありませんね。猫写真をアップしてください。";

        //     return redirect()->back()->with('cat_error',$cat_error);
        // }
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
        $microposts = $microposts->toJson();
        // dd($microposts);
        return view('microposts.all_map', ['microposts' => $microposts]);
    }
   
}