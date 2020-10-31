<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable=['id','article_id','user_id','body','created_at','updated_at'];

    public function author() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

}
