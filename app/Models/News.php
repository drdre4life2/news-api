<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
   protected $fillable =[
       'title','content' ,
       'author','category',
       'published_at' ,'source',
       'url','image_url',
       'created_at', 'updated_at',
   ];
}
