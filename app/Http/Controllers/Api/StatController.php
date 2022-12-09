<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Post;
use App\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $users             = User::count();
        $posts             = Post::count();

        $userswithpost  = Post::select('user_id')->get();
        $userswithposts = Post::WhereIn('id', $userswithpost)->count();
        $usersWithOutPosts = $users - $userswithposts;

        return $this->apiResponse(
        [
            'Number of all users: ' =>$users,
            'Number of all posts: ' => $posts,
            'Number of all users with 0 posts: ' => $usersWithOutPosts,
        ], 'Ok', 200);
    }
}
