<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $posts = Post::get();
        return $this->apiResponse($posts,'Ok',200);
    }



    public function show($id)
    {
        $post = Post::find($id);
        
        if($post)
        {
            return $this->apiResponse($post,'Ok',200);
        }

        return $this->apiResponse(null,'The Post Not Found',404);
    }



    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(),
        [
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        if ($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $post = Post::create($request->all());

        if($post)
        {
            return $this->apiResponse($post,'The Post Save',201);
        }

        return $this->apiResponse(null,'The Post Not Save',400);
    }



    public function update(Request $request ,$id)
    {
        $validator  = Validator::make($request->all(),
        [
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        if ($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $post = Post::find($id);

        if(!$post)
        {
            return $this->apiResponse(null,'The Post Not Found',404);
        }

        $post->update($request->all());

        if($post)
        {
            return $this->apiResponse($post,'The Post Update',201);
        }

    }



    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post)
        {
            return $this->apiResponse(null,'The Post Not Found',404);
        }

        $post->delete($id);

        if($post)
        {
            return $this->apiResponse(null,'The Post Deleted',200);
        }

    }
}
