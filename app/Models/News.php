<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class News extends Model
{
    use HasFactory;

    private string $modelNotFound = 'News not found';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getAllNews()
    {
        $news = $this->all();

        return okResponse200($news, 'News retrived successfully');
    }

    public function getOneNews($id)
    {
        try {
            $news = $this->findOrFail($id);

            $news->user;
            $news->category;
            $news->comments;

            return okResponse200($news, 'News retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOnewNews(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'slug' => 'string',
                'content' => 'required|string',
                'image' => 'image',
                'category_id' => 'integer'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $news = new $this;

            $news->name = $request->name;

            if ($request->has('slug')) {
                $news->slug = $request->slug;
            }
            $news->content = $request->content;
            $news->user_id = Auth::user()->id;

            if ($request->has('image')) {
                $news->image = upLoadImage($request->image, 'news');
            }

            if ($request->has('category_id')) {
                Category::findOrFail($request->category_id);

                $news->category_id = $request->category_id;
            }

            $news->save();


            return resourceCreatedResponse201($news, 'News created successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse('Category ID not found');
        }
    }

    public function updateOneNews(Request $request, $id)
    {
        try {
            $news = $this->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'slug' => 'string',
                'content' => 'string',
                'image' => 'image',
                'category_id' => 'integer'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            if ($request->has('name')) {
                $news->name = $request->name;
            }

            if ($request->has('slug')) {
                $news->slug = $request->slug;
            }

            if ($request->has('content')) {
                $news->content = $request->content;
            }
            $news->user_id = Auth::user()->id;

            if ($request->has('image')) {
                $news->image = updateImage($news->image, $request->image, 'news');
            }

            if ($request->has('category_id')) {
                if (!Category::find($request->category_id)) {
                    return modelNotFoundResponse('Category ID not found');
                }
                $news->category_id = $request->category_id;
            }

            $news->update();

            return okResponse200($news, 'News updated successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function destroyOneNews($id)
    {
        try {
            $news = $this->findOrFail($id);
            $image = $news->image;

            $news->delete();
            destroyImage($image);

            return okResponse200($news, 'News deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
