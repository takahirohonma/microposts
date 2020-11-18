<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * このユーザが所有する投稿。（ Micropostモデルとの関係を定義）
     */
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    //このユーザーがフォローフォロー中のユーザー
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }
    
    //このユーザーをフォロー中のユーザー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    public function follow($userId)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // すでにフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    public function unfollow($userId)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // すでにフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    
    public function is_following($userId)
    {
        // フォロー中ユーザの中に $userIdのものが存在するか
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    public function loadRelationshipCounts()
    {
        
        $this->loadCount(['microposts', 'followings', 'followers', 'favorites']);
    }
    
    public function feed_microposts(){
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id', $userIds);
    }
    
    
    
    //お気に入り機能
    public function favorites(){
        return $this->belongsToMany(Micropost::class, 'user_favorites','user_id', 'micropost_id')->withTimestamps();
    }
    
    public function favorite($postId){
        $exist = $this->is_favorite($postId);
        //投稿をお気に入りにしているかどうかの確認
        // $its_me = $this->id == $postId;

        if ($exist) {
            // すでにお気に入りにしていれば何もしない
            return false;
        } else {
            // お気に入りにしていなければ登録する
            $this->favorites()->attach($postId);
            return true;
        }
    }
    
    public function unfavorite($postId){
        $exist = $this->is_favorite($postId);
        // $its_me = $this->id == $postId;

        if ($exist) {
            // お気に入りならば外す
            $this->favorites()->detach($postId);
            return true;
        } else {
            // すでにお気に入りにしていれば何もしない
            return false;
        }
    }
    
    public function is_favorite($postId)
    {
        // 投稿内容に $micropostIdのものが存在するか
        return $this->favorites()->where('micropost_id', $postId)->exists();
    }
    
}
