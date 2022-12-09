<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $table    = 'post_tag';
    protected $fillable = ['post_id', 'tag_id'];
}
