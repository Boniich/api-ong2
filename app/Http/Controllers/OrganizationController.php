<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    private $organization;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/organization",
     *      tags={"Organization"},
     *      summary="Display organization data",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Organization retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "ONG LARAVEL",
     *                          "logo": "organization/image.png",
     *                          "short_description": "Somos una ONG que se dedica a enseñarle PHP y LARAVEL a los niños",
     *                          "long_description": "ONG dedicada a la enseñanza",
     *                          "welcome_text": "Bienvenidos a la ONG LARAVEl",
     *                          "address": "Calle Falsa 123",
     *                          "phone": "123456",
     *                          "cell_phone": "123456",
     *                          "facebook_url": "facebook/ongLaravel",
     *                          "linkedin_url": "linkedin/ongLaravel",
     *                          "instagram_url": "instagram/ongLaravel",
     *                          "twitter_url": "twitter/ongLaravel",
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Organization retrived successfully"),
     *      ),
     *  ),
     *     @OA\Response(
     *          response=401,
     *          description="User is not authenticated",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="401"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Unauthenticated"),
     *          ),
     *      )
     * )
     * 
     */

    public function index()
    {
        return $this->organization->getOrganizationData();
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/organization",
     *      tags={"Organization"},
     *      summary="Update organization data",
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          @OA\Property(property="name", type="string", format="string"),
     *          @OA\Property(property="short_description", type="string", format="string"),
     *          @OA\Property(property="long_description", type="string", format="string"),
     *          @OA\Property(property="welcome_text", type="string", format="string"),
     *          @OA\Property(property="address", type="string", format="string"),
     *          @OA\Property(property="phone", type="string", format="string"),
     *          @OA\Property(property="cell_phone", type="string", format="string"),
     *          @OA\Property(property="facebook_url", type="string", format="string"),
     *          @OA\Property(property="linkedin_url", type="string", format="string"),
     *          @OA\Property(property="instagram_url", type="string", format="string"),
     *          @OA\Property(property="twitter_url", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Organization data updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "ONG LARAVEL",
     *                          "logo": "organization/image.png",
     *                          "short_description": "Somos una ONG que se dedica a enseñarle PHP y LARAVEL a los niños",
     *                          "long_description": "ONG dedicada a la enseñanza",
     *                          "welcome_text": "Bienvenidos a la ONG LARAVEl",
     *                          "address": "Calle Falsa 123",
     *                          "phone": "123456",
     *                          "cell_phone": "123456",
     *                          "facebook_url": "facebook/ongLaravel",
     *                          "linkedin_url": "linkedin/ongLaravel",
     *                          "instagram_url": "instagram/ongLaravel",
     *                          "twitter_url": "twitter/ongLaravel",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Organization data updated successfully"),
     *      ),  
     *      ),
     *  )
     */

    public function update(Request $request)
    {
        return $this->organization->updateOrganizationData($request);
    }
}
