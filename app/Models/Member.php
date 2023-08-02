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

    private function successResponse(object $data, string $message)
    {
        return ['success' => true, 'data' => $data, 'message' => $message];
    }

    private function errorResponse(string $message)
    {
        return ['success' => false, 'error' => $message];
    }

    public function getAllMembers()
    {
        $members = $this->all();

        return response()->json($this->successResponse($members, 'Members retrived successfully'));
    }

    public function getMemberById($id)
    {
        try {
            $member = $this->findOrFail($id);

            return response()->json($this->successResponse($member, 'Member retrived successfully'));
        } catch (ModelNotFoundException $th) {

            return response()->json($this->errorResponse($this->notFoundMsg), 404);
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
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                Storage::disk('public')->put('members/' . $imageName, file_get_contents($request->image));

                $newMember->image = 'members/' . $imageName;
            }

            $newMember->facebook_url = $request->facebook_url;
            $newMember->linkedin_url = $request->linkedin_url;

            $newMember->save();

            return response()->json($this->successResponse($newMember, 'Member created successfully'), 201);
        } catch (\Throwable $th) {

            return response()->json($this->errorResponse('Bad Request'));
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

                $image = $member->image;

                if (!is_null($image)) {
                    $isThereAnImage = Storage::disk('public')->exists($image);

                    if ($isThereAnImage) {
                        Storage::disk('public')->delete($image);
                    }
                }
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                Storage::disk('public')->put('members/' . $imageName, file_get_contents($request->image));

                $member->image = 'members/' . $imageName;
            }

            if ($request->has('facebook_url')) {
                $member->facebook_url = $request->facebook_url;
            }

            if ($request->has('linkedin_url')) {
                $member->linkedin_url = $request->linkedin_url;
            }

            $member->update();

            return response()->json($this->successResponse($member, 'Member updated successfully'));
        } catch (ModelNotFoundException $th) {
            return response()->json($this->errorResponse($this->notFoundMsg), 404);
        }
    }


    public function destroyMember($id)
    {
        try {
            $member = $this->findOrFail($id);

            $image = $member->image;

            if (!is_null($image)) {
                $isThereAnImage = Storage::disk('public')->exists($image);

                if ($isThereAnImage) {
                    Storage::disk('public')->delete($image);
                }
            }

            $member->delete();
            return response()->json($this->successResponse($member, 'Member deleted successfully'));
        } catch (ModelNotFoundException $th) {
            return response()->json($this->errorResponse($this->notFoundMsg), 404);
        }
    }
}
