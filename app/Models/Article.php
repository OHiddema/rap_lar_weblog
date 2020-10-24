<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable=['title','excerpt','body'];

    // use another function name then 'user' => use second argument in belongsTo to
    // recognize the link between both models
    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function tags()
    {
        return $this->belongstoToMany(Tag::class);
    }
}
