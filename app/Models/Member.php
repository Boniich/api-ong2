<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use HasFactory;

    private string $notFoundMsg = "Member not found";

    public function getAllMembers()
    {
        $members = $this->all();

        return okResponse200($members, 'Members retrived successfully');
    }

    public function getMemberById($id)
    {
        try {
            $member = $this->findOrFail($id);

            return okResponse200($member, 'Member retrived successfully');
        } catch (ModelNotFoundException $th) {

            return modelNotFoundResponse($this->notFoundMsg);
        }
    }

    public function storeMember(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required|string',
                'description' => 'required|string',
                'image' => 'image',
                'facebook_url' => 'string',
                'linkedin_url' => 'string',
            ]);



            $newMember = new Member;

            $newMember->full_name = $request->full_name;
            $newMember->description = $request->description;

            if ($request->has('image')) {
                $newMember->image = upLoadImage($request->image, 'members');
            }

            $newMember->facebook_url = $request->facebook_url;
            $newMember->linkedin_url = $request->linkedin_url;

            $newMember->save();

            return resourceCreatedResponse201($newMember, 'Member created successfully');
        } catch (\Throwable $th) {

            return badRequestResponse400();
        }
    }

    public function updateMember(Request $request, $id)
    {
        try {
            $request->validate([
                'full_name' => 'string',
                'description' => 'string',
                'image' => 'image',
                'facebook_url' => 'string',
                'linkedin_url' => 'string',
            ]);

            $member = $this->findOrFail($id);

            if ($request->has('full_name')) {
                $member->full_name = $request->full_name;
            }

            if ($request->has('description')) {
                $member->description = $request->description;
            }

            if ($request->has('image')) {

                $imageLoaded = $member->image;
                $imageInRequest = $request->image;

                $member->image = updateImage($imageLoaded, $imageInRequest, 'members');
            }

            if ($request->has('facebook_url')) {
                $member->facebook_url = $request->facebook_url;
            }

            if ($request->has('linkedin_url')) {
                $member->linkedin_url = $request->linkedin_url;
            }

            $member->update();

            return okResponse200($member, 'Member updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->notFoundMsg);
        }
    }


    public function destroyMember($id)
    {
        try {
            $member = $this->findOrFail($id);

            $image = $member->image;

            destroyImage($image);
            $member->delete();
            return okResponse200($member, 'Member deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->notFoundMsg);
        }
    }
}
