<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Organization extends Model
{
    use HasFactory;

    public function getOrganizationData()
    {
        $data = $this->all();

        return okResponse200($data, 'Organization retrived successfully');
    }

    public function updateOrganizationData(Request $request)
    {
        try {
            $request->validate([
                'name' => 'string',
                'logo' => 'image',
                'short_description' => 'string',
                'long_description' => 'string',
                'welcome_text' => 'string',
                'address' => 'string',
                'phone' => 'string',
                'cell_phone' => 'string',
                'facebook_url' => 'string',
                'linkedin_url' => 'string',
                'instagram_url' => 'string',
                'twitter_url' => 'string',
            ]);

            $id = 1;

            $organization = $this->findOrFail($id);

            if ($request->has('name')) {
                $organization->name = $request->name;
            }

            if ($request->has('logo')) {
                $organization->logo = updateImage($organization->logo, $request->logo, 'organization');
            }

            if ($request->has('short_description')) {
                $organization->short_description = $request->short_description;
            }

            if ($request->has('long_description')) {
                $organization->long_description = $request->long_description;
            }

            if ($request->has('welcome_text')) {
                $organization->welcome_text = $request->welcome_text;
            }

            if ($request->has('address')) {
                $organization->address = $request->address;
            }

            if ($request->has('phone')) {
                $organization->phone = $request->phone;
            }

            if ($request->has('cell_phone')) {
                $organization->cell_phone = $request->cell_phone;
            }

            if ($request->has('facebook_url')) {
                $organization->facebook_url = $request->facebook_url;
            }

            if ($request->has('linkedin_url')) {
                $organization->linkedin_url = $request->linkedin_url;
            }

            if ($request->has('instagram_url')) {
                $organization->instagram_url = $request->instagram_url;
            }

            if ($request->has('twitter_url')) {
                $organization->twitter_url = $request->twitter_url;
            }

            $organization->update();

            return okResponse200($organization, 'Organization data updated successfully');
        } catch (\Throwable $th) {
            return response()->json(errorResponse('An Error Ocurred! Try again'), 500);
        }
    }
}
