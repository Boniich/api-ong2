<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    private Activity $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function index()
    {
        return $this->activity->getAllActivities();
    }

    public function show($id)
    {
        return $this->activity->getOneActivity($id);
    }

    public function store(Request $request)
    {
        return $this->activity->storeOneActivity($request);
    }

    public function update(Request $request, $id)
    {
        return $this->activity->updateOneActivity($request, $id);
    }

    public function destroy($id)
    {
        return $this->activity->destroyOneActivity($id);
    }
}
