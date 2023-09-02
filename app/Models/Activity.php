<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Activity extends Model
{
    use HasFactory;

    private string $modelNoFound = 'Activity not found';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getAllActivities()
    {
        $activities = $this->all();

        return okResponse200($activities, 'Activities retrived successfully');
    }

    public function getOneActivity($id)
    {
        try {
            $activity = $this->findOrFail($id);

            $activity->user;
            $activity->category;

            return okResponse200($activity, 'Activity retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNoFound);
        }
    }

    public function storeOneActivity(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'slug' => 'string',
                'description' => 'required|string',
                'image' => 'image',
                'category_id' => 'integer'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $newActivity = new $this;

            $newActivity->name = $request->name;

            if ($request->has('slug')) {
                $newActivity->slug = $request->slug;
            }
            $newActivity->description = $request->description;
            $newActivity->user_id = Auth::user()->id;

            if ($request->has('image')) {
                $newActivity->image = upLoadImage($request->image, 'activities');
            }

            if ($request->has('category_id')) {
                Category::findOrFail($request->category_id);

                $newActivity->category_id = $request->category_id;
            }

            $newActivity->save();

            return resourceCreatedResponse201($newActivity, 'Activity created successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse('Category ID not found');
        }
    }

    public function updateOneActivity(Request $request, $id)
    {
        try {
            $activity = $this->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'slug' => 'string',
                'description' => 'string',
                'image' => 'image',
                'category_id' => 'integer'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            if ($request->has('name')) {
                $activity->name = $request->name;
            }

            if ($request->has('slug')) {
                $activity->slug = $request->slug;
            }

            if ($request->has('description')) {
                $activity->description = $request->description;
            }

            if ($request->has('image')) {
                $activity->image = updateImage($activity->image, $request->image, 'activities');
            }

            if ($request->has('category_id')) {
                if (!Category::find($request->category_id)) {
                    return modelNotFoundResponse('Category ID not found');
                }
                $activity->category_id = $request->category_id;
            }

            $activity->update();

            return okResponse200($activity, 'Activity updated successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse($this->modelNoFound);
        }
    }


    public function destroyOneActivity($id)
    {
        try {
            $activity = $this->findOrFail($id);
            $image = $activity->image;

            $activity->delete();
            destroyImage($image);

            return okResponse200($activity, "Activity deleted successfully");
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNoFound);
        }
    }
}
