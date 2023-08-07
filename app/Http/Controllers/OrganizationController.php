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

    public function index()
    {
        return $this->organization->getOrganizationData();
    }

    public function update(Request $request)
    {
        return $this->organization->updateOrganizationData($request);
    }
}
