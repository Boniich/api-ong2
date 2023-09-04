<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        return $this->comment->getAllComments();
    }

    public function show($id)
    {
        return $this->comment->getOneComment($id);
    }

    public function store(Request $request)
    {
        return $this->comment->storeOneComment($request);
    }

    public function update(Request $request, $id)
    {
        return $this->comment->updateOneComment($request, $id);
    }

    public function destroy($id)
    {
        return $this->comment->destroyOneComment($id);
    }
}
