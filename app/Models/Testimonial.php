<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Testimonial extends Model
{
    use HasFactory;

    private string $modelNotFound = 'Testimonial not found';

    public function getAllTestimonials()
    {
        $testimonials = $this->all();

        return okResponse200($testimonials, 'Testimonials retrived successfully');
    }

    public function getOneTestimonialById($id)
    {
        try {
            $testimonial = $this->findOrFail($id);

            return okResponse200($testimonial, 'Testimonial retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneTestimonial(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'image' => 'image',
                'description' => 'required|string'
            ]);

            $newTestimonial = new $this;

            $newTestimonial->name = $request->name;
            if ($request->has('image')) {
                $newTestimonial->image = upLoadImage($request->image, 'testimonials');
            }
            $newTestimonial->description = $request->description;

            $newTestimonial->save();

            return resourceCreatedResponse201($newTestimonial, 'Testimonial created successfully');
        } catch (\Throwable $th) {
            return badRequestResponse400();
        }
    }

    public function updateOneTestimonial(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string',
                'image' => 'image',
                'description' => 'string'
            ]);

            $testimonial = $this->findOrFail($id);

            if ($request->has('name')) {
                $testimonial->name = $request->name;
            }

            if ($request->has('image')) {
                $testimonial->image = updateImage($testimonial->image, $request->image, 'testimonials');
            }

            if ($request->has('description')) {
                $testimonial->description = $request->description;
            }

            $testimonial->update();

            return okResponse200($testimonial, 'Testimonial updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function destroyTestimonial($id)
    {
        try {
            $testimonial = $this->findOrFail($id);
            $image = $testimonial->image;

            $testimonial->delete();
            destroyImage($image);

            return okResponse200($testimonial, 'Testimonial deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
