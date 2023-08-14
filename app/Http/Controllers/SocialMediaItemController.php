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

    public function index()
    {
        return $this->socialMediaItem->getAllSocialMediaItems();
    }

    public function show($id)
    {
        return $this->socialMediaItem->getOneSocialMediaItemsById($id);
    }

    public function store(Request $request)
    {
        return $this->socialMediaItem->storeOneSocialMediaItem($request);
    }

    public function update(Request $request, $id)
    {
        return $this->socialMediaItem->updateOneSocialMediaItem($request, $id);
    }

    public function destroy($id)
    {
        return $this->socialMediaItem->destroyOneSocialMediaItem($id);
    }
}
