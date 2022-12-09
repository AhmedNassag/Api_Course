<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Tag;


class TagController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $tags = Tag::select('id', 'name')->get();

        return $this->apiResponse($tags, 'Ok', 200);
    }



    public function show($id)
    {
        $tag = Tag::select('id', 'name')->find($id);
        $postsCount = $tag->posts->count();

        if ($tag)
        {
            return $this->apiResponse(['tag'=>$tag, 'postsCount'=>$postsCount], 'Ok', 200);
        }

        return $this->apiResponse(null, 'The Tag Not Found', 404);
    }



    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(),
            [
                'name' => 'required|unique:tags,name',
            ]
        );

        if ($validator->fails())
        {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $tag = Tag::create($request->all());

        if ($tag)
        {
            return $this->apiResponse($tag, 'The Tag Saved', 201);
        }

        return $this->apiResponse(null, 'The Tag Not Saved', 400);
    }



    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        if($tag)
        {
            $validator  = Validator::make($request->all(),
                [
                    'name' => 'required|unique:tags,name,' .$tag->id,
                ]
            );

            if ($validator->fails())
            {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            $tag->update($request->all());

            return $this->apiResponse($tag, 'The Tag Updated', 201);
        }

        return $this->apiResponse(null, 'The Tag Not Found', 404);
    }



    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag)
        {
            return $this->apiResponse(null, 'The Tag Not Found', 404);
        }

        $tag->delete($id);

        if ($tag)
        {
            return $this->apiResponse(null, 'The Tag Deleted', 200);
        }
    }
}
