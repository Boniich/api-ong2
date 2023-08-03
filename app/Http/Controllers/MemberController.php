<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    private $members;

    public function __construct(Member $member)
    {
        $this->members = $member;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/members",
     *      tags={"Members"},
     *      summary="Display a list of members",
     *      @OA\Response(
     *          response=200,
     *          description="Members retrived successfully",
     *      )
     *  )
     * 
     */

    public function index()
    {
        return $this->members->getAllMembers();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/members/{id}",
     *      tags={"Members"},
     *      summary="Display a member by id",
     *  
     *      @OA\Parameter(
     *          description="id of member",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Member retrived successfully",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Member not found",
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->members->getMemberById($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/members",
     *      tags={"Members"},
     *      summary="Create a new member",
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          required={"full_name","description"},
     *          @OA\Property(property="id", type="integer", format="string"),
     *          @OA\Property(property="full_name", type="string", format="string"),
     *          @OA\Property(property="description", type="string", format="string" ),
     *          @OA\Property(property="image", type="string", format="string"),
     *          @OA\Property(property="facebook_url", type="string", format="string"),
     *          @OA\Property(property="linkeding_url", type="string", format="string"),
     *      ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Member created successfully"  
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request"  
     *      )
     *   )
     * 
     */

    public function store(Request $request)
    {
        return $this->members->storeMember($request);
    }


    /**
     *  @OA\Put(
     *      path="/api/v1/members/{id}",
     *      tags={"Members"},
     *      summary="Update a member by id",
     * 
     *      @OA\Parameter(
     *          description="id of member",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          @OA\Property(property="id", type="integer", format="string"),
     *          @OA\Property(property="full_name", type="string", format="string"),
     *          @OA\Property(property="description", type="string", format="string" ),
     *          @OA\Property(property="image", type="string", format="string"),
     *          @OA\Property(property="facebook_url", type="string", format="string"),
     *          @OA\Property(property="linkedin_url", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Member updated successfully",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Member not found",
     *      )
     *  )
     */

    public function update(Request $request, $id)
    {
        return $this->members->updateMember($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/members/{id}",
     *      tags={"Members"},
     *      summary="Delete a member",
     * 
     *      @OA\Parameter(
     *          description="id of member",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Member deleted successfully",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Member not found",
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->members->destroyMember($id);
    }
}
