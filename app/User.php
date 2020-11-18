<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_image_path', 'fovo_photos_order'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public function microposts(){
        return $this->hasMany(Micropost::class);
    }
    



    //follow: User-User間の多:多の表現
    public function followings()//自分がフォローしているユーザーたちを獲得
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    public function followers()//フォローしてくれてる関係になるユーザーたちを獲得
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    
    //操作しようとしている$userIDがすでにfollow_idカラムに存在しているかどうか=既followかどうかの判定関数
    public function is_following($userId) {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    
    public function follow($userId)
    {
        // 既にフォローしているかの確認boolian
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認boolian
        $its_me = $this->id == $userId;
    
        if ($exist || $its_me) {
            // 自分をフォローしようとしているか、既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    
    public function unfollow($userId)
    {
        // 既にフォローしているかの確認boolian
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認boolian
        $its_me = $this->id == $userId;
    
        if ($exist && !$its_me) {
            // 既にフォローしていれば(かつ自分でなければ)フォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローをunfollowしようとしたときは何もしないでfalseを返す
            return false;
        }
    }
    
    
    

    //タイムライン=(フォローしてる人+自分)のmicropostsを表示するためのメソッド
    // 最後に return Micropost::whereIn('user_id', $follow_user_ids); では、 microposts テーブルの user_id カラムで $follow_user_ids の中の id を含む場合に、全て取得して return します。
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }


    //favorite: User-Micropost間の多：多の表現
    public function favoritings()//自分がファヴォているmicropostたちを獲得
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id' ,'micropost_id')->withTimestamps();
    }
    
   
    //ファヴォしているかのチェックメソッド（ID検索）
    public function is_favoriting($micropostId) {
        return $this->favoritings()->where('micropost_id', $micropostId)->exists();
    }
    
    
    public function favorite($micropostId)
    {
        // 既にファヴォしているかの確認
        $exist = $this->is_favoriting($micropostId);
        
        if ($exist) {
            // 既にファヴォしていれば何もしない
            return false;
        } else {
            // 未ファヴォであればファヴォする
            $this->favoritings()->attach($micropostId);
            return true;
        }
    }
    
    public function unfavorite($micropostId)
    {
        // 既にファヴォしているかの確認
        $exist = $this->is_favoriting($micropostId);
    
        if ($exist) {
            // 既にファヴォしていればファヴォを外す
            $this->favoritings()->detach($micropostId);
            return true;
        } else {
            // 未ファヴォであれば何もしない
            return false;
        }
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
