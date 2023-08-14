<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaItem;
use Illuminate\Http\Request;

class SocialMediaItemController extends Controller
{
    private $socialMediaItem;

    public function __construct(SocialMediaItem $socialMediaItem)
    {
        $this->socialMediaItem = $socialMediaItem;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/socialmediaitems",
     *      tags={"SocialMediaItems"},
     *      summary="Display a list of social media items",
     *      @OA\Response(
     *          response=200,
     *          description="Social Media Items retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Facebook",
     *                          "image": "socialMediaItems/12345593.png",
     *                          "url": "facebook/ong",
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Social Media Items retrived successfully"),
     *      ),
     *  ),
     * )
     * 
     */

    public function index()
    {
        return $this->socialMediaItem->getAllSocialMediaItems();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/socialmediaitems/{id}",
     *      tags={"SocialMediaItems"},
     *      summary="Display a social media item by id",
     *  
     *      @OA\Parameter(
     *          description="id of social media item",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Social Media Item retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Facebook",
     *                          "image": "socialMediaItems/12345593.png",
     *                          "url": "facebook/ong",
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Social Media Item retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Social Media Item not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Social Media Item not found"),
     *              ),
     *          ),
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->socialMediaItem->getOneSocialMediaItemsById($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/socialmediaitems",
     *      tags={"SocialMediaItems"},
     *      summary="Create a new social media item",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *		        @OA\Property(
     *                     description="name of social media",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image of social media",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *              @OA\Property(
     *                     description="url of social media",
     *                     property="url",
     *                     type="string",
     *                     format="string",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Social Media Item created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Facebook",
     *                          "image": "socialMediaItems/12345593.png",
     *                          "url": "facebook/ong",
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Social Media Item created successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request",  
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Bad Request"),
     *          ),
     *      )
     *   )
     * 
     */


    public function store(Request $request)
    {
        return $this->socialMediaItem->storeOneSocialMediaItem($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/socialmediaitems/{id}",
     *      tags={"SocialMediaItems"},
     *      summary="Update a social media item by id",
     * 
     *      @OA\Parameter(
     *          description="id of social media item",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", format="string"),
     *              @OA\Property(property="url", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Social Media Item updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Facebook",
     *                          "image": "socialMediaItems/12345593.png",
     *                          "url": "facebook/ong",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Social Media Item updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Social Media Item not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Social Media Item not found"),
     *          ),
     *      )
     *  )
     */

    public function update(Request $request, $id)
    {
        return $this->socialMediaItem->updateOneSocialMediaItem($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/socialmediaitems/{id}",
     *      tags={"SocialMediaItems"},
     *      summary="Delete a social media item",
     * 
     *      @OA\Parameter(
     *          description="id of social media item",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Social Media Item deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Facebook",
     *                          "image": "socialMediaItems/12345593.png",
     *                          "url": "facebook/ong",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Social Media Item deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Social Media Item not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Social Media Item not found"),
     *          ),
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->socialMediaItem->destroyOneSocialMediaItem($id);
    }
}
