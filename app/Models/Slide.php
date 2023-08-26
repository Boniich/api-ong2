<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Slide extends Model
{
    use HasFactory;

    private string $modelNotFound = 'Slide not found';

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAllSlides()
    {
        $slides = $this->all();

        foreach ($slides as $key => $value) {
            $value->users;
        }

        return okResponse200($slides, 'Slides retrived successfully');
    }

    public function getOneSlideById($id)
    {
        try {
            $slide = $this->findOrFail($id);

            $slide->users;

            return okResponse200($slide, 'Slide retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneSlide(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|image',
            ]);


            if ($validator->fails()) {
                throw new BadRequestException;
            }


            $newSlide = new $this;

            $newSlide->name = $request->name;
            $newSlide->description = $request->description;
            $newSlide->image = upLoadImage($request->image, 'slides');
            $newSlide->user_id = Auth::user()->id;

            $newSlide->save();

            return resourceCreatedResponse201($newSlide, "Slide created successfully");
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        }
    }

    public function updateOneSlide(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'description' => 'string',
                'image' => 'image',
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }


            $slide = $this->findOrFail($id);


            if ($request->has('name')) {
                $slide->name = $request->name;
            }

            if ($request->has('description')) {
                $slide->description = $request->description;
            }

            if ($request->has('image')) {
                $slide->image = updateImage($slide->image, $request->image, 'slides');
            }

            $slide->update();

            return okResponse200($slide, "Slide updated successfully");
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        } catch (BadRequestException) {
            return badRequestResponse400();
        }
    }

    public function destroyOneSlide($id)
    {
        try {
            $slide = $this->findOrFail($id);
            $image = $slide->image;

            $slide->delete();
            destroyImage($image);

            return okResponse200($slide, "Slide deleted successfully");
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
