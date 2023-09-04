<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Category extends Model
{
    use HasFactory;

    private string $modelNotFound = 'Category not found';

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function getAllCategories()
    {
        $categories = $this->all();

        return okResponse200($categories, 'Categories retrived successfully');
    }

    public function getOneCategory($id)
    {
        try {
            $category = $this->findOrFail($id);

            $category->activities;
            $category->news;

            return okResponse200($category, 'Category retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneCategory(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'image',
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $newCategory = new $this;

            $newCategory->name = $request->name;
            $newCategory->description = $request->description;

            if ($request->has('image')) {
                $newCategory->image = upLoadImage($request->image, 'categories');
            }

            $newCategory->save();

            return resourceCreatedResponse201($newCategory, 'Category created successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        }
    }

    public function updateOneCategory(Request $request, $id)
    {
        try {
            $category = $this->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'description' => 'string',
                'image' => 'image',
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            if ($request->has('name')) {
                $category->name = $request->name;
            }

            if ($request->has('description')) {
                $category->description = $request->description;
            }

            if ($request->has('image')) {
                $category->image = updateImage($category->image, $request->image, 'categories');
            }

            $category->update();

            return okResponse200($category, 'Category updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        } catch (BadRequestException) {
            return badRequestResponse400();
        }
    }

    public function destroyOneCategory($id)
    {
        try {
            $category = $this->findOrFail($id);
            $image = $category->image;

            $category->delete();
            destroyImage($image);

            return okResponse200($category, 'Category deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
