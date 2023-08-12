<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Project extends Model
{
    use HasFactory;

    private $modelNotFound = 'Project not found';

    public function getAllProjects()
    {
        $projects = $this->all();

        return okResponse200($projects, 'Projects retrived successfully');
    }

    public function getOneProjectById($id)
    {
        try {
            $project = $this->findOrFail($id);

            return okResponse200($project, 'Project retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneProject(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'required|string|max:200',
                'image' => 'required|image',
                'due_date' => 'required|string'
            ]);

            $newProject = new $this;


            $newProject->title = $request->title;
            $newProject->description = $request->description;
            $newProject->image = upLoadImage($request->image, 'projects');
            $newProject->due_date = $request->due_date;

            $newProject->save();

            return resourceCreatedResponse201($newProject, 'Project created successfully');
        } catch (\Throwable $th) {
            return badRequestResponse400();
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'string',
                'description' => 'string|max:200',
                'image' => 'image',
                'due_date' => 'string'
            ]);

            $project = $this->findOrFail($id);

            if ($request->has('title')) {
                $project->title = $request->title;
            }

            if ($request->has('title')) {
                $project->description = $request->description;
            }

            if ($request->has('image')) {
                $project->image = updateImage($project->image, $request->image, 'projects');
            }

            if ($request->has('due_date')) {
                $project->due_date = $request->due_date;
            }

            $project->update();

            return okResponse200($project, 'Project updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function destroyProject($id)
    {
        try {
            $project = $this->findOrFail($id);
            $image = $project->image;

            $project->delete();
            destroyImage($image);

            return okResponse200($project, 'Project deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
