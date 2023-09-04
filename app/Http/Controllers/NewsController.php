<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        return $this->news->getAllNews();
    }

    public function show($id)
    {
        return $this->news->getOneNews($id);
    }

    public function store(Request $request)
    {
        return $this->news->storeOnewNews($request);
    }

    public function update(Request $request, $id)
    {
        return $this->news->updateOneNews($request, $id);
    }

    public function destroy($id)
    {
        return $this->news->destroyOneNews($id);
    }
}
