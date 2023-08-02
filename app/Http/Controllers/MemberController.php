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

    public function index()
    {
        return $this->members->getAllMembers();
    }

    public function show($id)
    {
        return $this->members->getMemberById($id);
    }

    public function store(Request $request)
    {
        return $this->members->storeMember($request);
    }

    public function update(Request $request, $id)
    {
        return $this->members->updateMember($request, $id);
    }

    public function destroy($id)
    {
        return $this->members->destroyMember($id);
    }
}
