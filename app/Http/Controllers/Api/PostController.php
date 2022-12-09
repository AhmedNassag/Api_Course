<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Api\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $posts = Post::where('user_id', auth()->user()->id)->with('tags')->orderByDesc('pinned')->get();

        return $this->apiResponse($posts,'Ok',200);
    }



    public function show($id)
    {
        $post = Post::where(['id' => $id, 'user_id' => auth()->user()->id])->get();

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
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'required',
            // 'cover_image' => 'required|file|mimes:png,jpg,jpeg',
            'pinned'      => 'required|boolean',
        ]);

        if ($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        // $file_extension = $request->cover_image->getClientOriginalExtension();
        // $file_name      = time().'.'. $file_extension;
        // $path           = 'img';
        // $request->cover_image->move($path,$file_name);

        $post = Post::create([
            'title'       => $request->title,
            'body'        => $request->body,
            'pinned'      => $request->pinned,
            'user_id'     => auth()->user()->id,
            // 'cover_image' => $file_name,
            'cover_image' => $request->cover_image,
        ]);

        if($request->tags)
        {
            $post->tags()->attach($request->tags);
        }

        if($post)
        {
            return $this->apiResponse($post,'The Post Saved',201);
        }

        return $this->apiResponse(null,'The Post Not Saved',400);
    }



    public function update(Request $request ,$id)
    {
        $validator  = Validator::make($request->all(),
        [
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'nullable' .($request->hasFile('cover_image') ? '|file|mimes:jpeg,jpg,png' : ''),
            'pinned'      => 'required|boolean',
        ]);

        if ($validator->fails())
        {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $post = Post::where(['id'=> $id, 'user_id' => auth()->user()->id])->get();

        if(!$post)
        {
            return $this->apiResponse(null,'The Post Not Found',404);
        }

        else
        {
            // if ($request->hasFile('cover_image'))
            // {
            //     $file_extension = $request->cover_image->getClientOriginalExtension();
            //     $file_name      = time() . '.' . $file_extension;
            //     $path           = 'img';
            //     $request->cover_image->move($path, $file_name);

                $post->update([
                    'title'       => $request->title,
                    'body'        => $request->body,
                    'pinned'      => $request->pinned,
                    'user_id'     => auth()->user()->id,
                    // 'cover_image' => $file_name,
                    'cover_image' => $request->cover_image != Null ? $request->cover_image:'',
                ]);

                if ($request->tags)
                {
                    $post->tags()->attach($request->tags);
                }
            // }
        }

        if($post)
        {
            return $this->apiResponse($post,'The Post Updated',201);
        }

    }



    public function destroy($id)
    {
        $post = Post::withTrashed()->where(['id'=>$id, 'user_id' => auth()->user()->id])->first();

        if (!$post)
        {
            return $this->apiResponse(null, 'The Post Not Found', 404);
        }
        else
        {
            if ($post->trashed())
            {
                // Storage::disk('public')->delete($post->cover_image);
                $post->tags()->detach();
                $post->forceDelete();
                return $this->apiResponse(null, 'The Post Deleted', 200);
            }
            else
            {
                $post->delete();
                return $this->apiResponse(null, 'The Post Trashed', 200);
            }
        }
    }



    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->first();
        // $post = Post::withTrashed()->where(['id'=> $id, 'user_id'=> auth()->id()])->first();

        if (!$post)
        {
            return $this->apiResponse(null, 'The Post Not Found', 404);
        }
        else
        {
            if ($post->trashed())
            {
                $post->restore();
                return $this->apiResponse(null, 'The Post Restored', 200);
            }
            else
            {
                return $this->apiResponse(null, 'There Is An Error', 200);
            }
        }
    }

    public function trashed()
    {
        $posts = Post::where('user_id', auth()->id())->onlyTrashed()->get();
        return $this->apiResponse($posts, 'Ok', 200);
    }
}
