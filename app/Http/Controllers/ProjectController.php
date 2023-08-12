<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/projects",
     *      tags={"Projects"},
     *      summary="Display a list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Projects retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "title": "Project one",
     *                          "description": "Este es un proyecto de ejemplo",
     *                          "image": "projects/12345593.png",
     *                          "due_date": "12/08/2023",
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Projects retrived successfully"),
     *      ),
     *  ),
     * 
     * )
     * 
     */

    public function index()
    {
        return $this->project->getAllProjects();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/projects/{id}",
     *      tags={"Projects"},
     *      summary="Display a project by id",
     *  
     *      @OA\Parameter(
     *          description="id of project",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Project retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "title": "Project one",
     *                          "description": "Este es un proyecto de ejemplo",
     *                          "image": "projects/12345593.png",
     *                          "due_date": "12/08/2023",
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Project retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Project not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Project not found"),
     *              ),
     *          ),
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->project->getOneProjectById($id);
    }


    /**
     *  @OA\Post(
     *      path="/api/v1/projects",
     *      tags={"Projects"},
     *      summary="Create a new project",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *		          @OA\Property(
     *                     description="title of project",
     *                     property="title",
     *                     type="string",
     *                     format="string",
     *                 ),
     *               @OA\Property(
     *                     description="description of project",
     *                     property="description",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image to upload",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *              @OA\Property(
     *                     description="date of project",
     *                     property="due_date",
     *                     type="string",
     *                     format="string",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Project created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "title": "Project one",
     *                          "description": "Este es un proyecto de ejemplo",
     *                          "image": "projects/12345593.png",
     *                          "due_date": "12/08/2023",
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Project created successfully"),
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
        return $this->project->storeOneProject($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/projects/{id}",
     *      tags={"Projects"},
     *      summary="Update a projects by id",
     * 
     *      @OA\Parameter(
     *          description="id of project",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", format="string"),
     *              @OA\Property(property="description", type="string", format="string"),
     *              @OA\Property(property="due_date", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Project updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "title": "Project one",
     *                          "description": "Este es un proyecto de ejemplo",
     *                          "image": "projects/12345593.png",
     *                          "due_date": "12/08/2023",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Project updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Project not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Project not found"),
     *          ),
     *      )
     *  )
     */

    public function update(Request $request, $id)
    {
        return $this->project->updateProject($request, $id);
    }


    /**
     *  @OA\Delete(
     *      path="/api/v1/projects/{id}",
     *      tags={"Projects"},
     *      summary="Delete a project",
     * 
     *      @OA\Parameter(
     *          description="id of project",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Project deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "title": "Project one",
     *                          "description": "Este es un proyecto de ejemplo",
     *                          "image": "projects/12345593.png",
     *                          "due_date": "12/08/2023",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Project deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Project not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Project not found"),
     *          ),
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->project->destroyProject($id);
    }
}
