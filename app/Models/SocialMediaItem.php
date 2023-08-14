<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SocialMediaItem extends Model
{
    use HasFactory;

    private string $modelNotFound = 'Social Media Item not found';

    public function getAllSocialMediaItems()
    {
        $socialMediaItems = $this->all();

        return okResponse200($socialMediaItems, 'Social Media Items retrived successfully');
    }

    public function getOneSocialMediaItemsById($id)
    {
        try {
            $socialMediaItem = $this->findOrFail($id);

            return okResponse200($socialMediaItem, 'Social Media Item retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneSocialMediaItem(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'image' => 'image',
                'url' => 'required|string'
            ]);

            $newSocialMediaItem = new $this;

            $newSocialMediaItem->name = $request->name;

            if ($request->has('image')) {
                $newSocialMediaItem->image = upLoadImage($request->image, 'socialMediaItems');
            }
            $newSocialMediaItem->url = $request->url;

            $newSocialMediaItem->save();

            return resourceCreatedResponse201($newSocialMediaItem, 'Social Media Item created successfully');
        } catch (\Throwable $th) {
            return badRequestResponse400();
        }
    }

    public function updateOneSocialMediaItem(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string',
                'image' => 'image',
                'url' => 'string'
            ]);

            $socialMediaItem = $this->findOrFail($id);

            if ($request->has('name')) {
                $socialMediaItem->name = $request->name;
            }

            if ($request->has('image')) {
                $socialMediaItem->image = updateImage($socialMediaItem->image, $request->image, 'socialMediaItems');
            }

            if ($request->has('url')) {
                $socialMediaItem->url = $request->url;
            }

            $socialMediaItem->update();

            return okResponse200($socialMediaItem, 'Social Media Item updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function destroyOneSocialMediaItem($id)
    {
        try {
            $socialMediaItem = $this->findOrFail($id);
            $image = $socialMediaItem->image;

            $socialMediaItem->delete();
            destroyImage($image);

            return okResponse200($socialMediaItem, 'Social Media Item deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
