<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    private Slide $slide;

    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }

    public function index()
    {
        return $this->slide->getAllSlides();
    }

    public function show($id)
    {
        return $this->slide->getOneSlideById($id);
    }

    public function store(Request $request)
    {
        return $this->slide->storeOneSlide($request);
    }

    public function update(Request $request, $id)
    {
        return $this->slide->updateOneSlide($request, $id);
    }

    public function destroy($id)
    {
        return $this->slide->destroyOneSlide($id);
    }
}
