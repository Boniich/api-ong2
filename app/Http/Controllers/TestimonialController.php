<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    private $testimonial;

    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    public function index()
    {
        return $this->testimonial->getAllTestimonials();
    }

    public function show($id)
    {
        return $this->testimonial->getOneTestimonialById($id);
    }

    public function store(Request $request)
    {
        return $this->testimonial->storeOneTestimonial($request);
    }

    public function update(Request $request, $id)
    {
        return $this->testimonial->updateOneTestimonial($request, $id);
    }

    public function destroy($id)
    {
        return $this->testimonial->destroyTestimonial($id);
    }
}
