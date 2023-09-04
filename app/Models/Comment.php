<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Comment extends Model
{
    use HasFactory;

    private string $modelNotFound = 'Comment not found';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }


    public function getAllComments()
    {
        $comments = $this->all();

        return okResponse200($comments, 'Comments retrived successfully');
    }

    public function getOneComment($id)
    {
        try {
            $comment = $this->findOrFail($id);

            $comment->user;
            $comment->news;

            return okResponse200($comment, 'Comment retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneComment(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'text' => 'required|string|max:70',
                'image' => 'image',
                'news_id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $comment = new $this;

            $comment->text = $request->text;

            $comment->active = true;

            $comment->user_id = Auth::user()->id;

            if ($request->has('image')) {
                $comment->image = upLoadImage($request->image, 'comments');
            }

            News::findOrFail($request->news_id);
            $comment->news_id = $request->news_id;

            $comment->save();

            return resourceCreatedResponse201($comment, 'Comment created successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse('News ID not found');
        }
    }

    public function updateOneComment(Request $request, $id)
    {
        try {

            $comment = $this->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'text' => 'string|max:70',
                'image' => 'image',
                'active' => 'boolean',
                'news_id' => 'integer'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $comment->user_id = Auth::user()->id;

            if ($request->has('text')) {
                $comment->text = $request->text;
            }

            if ($request->has('active')) {
                $comment->active = $request->active;
            }

            if ($request->has('image')) {
                $comment->image = updateImage($comment->image, $request->image, 'comments');
            }

            if ($request->has('news_id')) {
                if (!News::find($request->news_id)) {
                    return modelNotFoundResponse('News ID not found');
                }
                $comment->news_id = $request->news_id;
            }

            $comment->update();

            return okResponse200($comment, 'Comment updated successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }


    public function destroyOneComment($id)
    {
        try {
            $comment = $this->findOrFail($id);
            $image = $comment->image;

            $comment->delete();
            destroyImage($comment);

            return okResponse200($comment, 'Comment deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
