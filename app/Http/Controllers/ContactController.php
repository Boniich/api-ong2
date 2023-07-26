<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contacts;

    public function __construct(Contact $contact)
    {
        $this->contacts = $contact;
    }

    public function index()
    {
        return $this->contacts->getAllContacts();
    }

    public function store(Request $request)
    {
        return $this->contacts->storeContacts($request);
    }

    public function show($id)
    {
        return $this->contacts->getContactById($id);
    }

    public function update(Request $request, $id)
    {
        return $this->contacts->updateContact($request, $id);
    }

    public function destroy($id)
    {
        return $this->contacts->destroyContact($id);
    }
}
