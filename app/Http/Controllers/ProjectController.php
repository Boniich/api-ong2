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

    public function index()
    {
        return $this->project->getAllProjects();
    }

    public function show($id)
    {
        return $this->project->getOneProjectById($id);
    }

    public function store(Request $request)
    {
        return $this->project->storeOneProject($request);
    }

    public function update(Request $request, $id)
    {
        return $this->project->updateProject($request, $id);
    }

    public function destroy($id)
    {
        return $this->project->destroyProject($id);
    }
}
