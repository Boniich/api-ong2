<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return $this->category->getAllCategories();
    }

    public function show($id)
    {
        return $this->category->getOneCategory($id);
    }

    public function store(Request $request)
    {
        return $this->category->storeOneCategory($request);
    }

    public function update(Request $request, $id)
    {
        return $this->category->updateOneCategory($request, $id);
    }

    public function destroy($id)
    {
        return $this->category->destroyOneCategory($id);
    }
}
