<?php

use App\Models\Api\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create ([
            'title'       => 'Post Title',
            'body'        => 'Post Body',
            'cover_image' => 'Post_Image.jpg',
            'pinned'      => 0,
            'user_id'     => 1,
        ]);
    }
}
