<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Contact extends Model
{
    use HasFactory;

    private string $modelNotFoundMsg = 'Contact not found';

    public function getAllContacts()
    {
        $contacts = $this->all();

        return okResponse200($contacts, 'Contacts retrived successfully');
    }

    public function storeContacts(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
                'phone' => 'required|string',
                'message' => 'required|string|max:400',
            ]);

            $newContact = new Contact;

            $newContact->name = $request->name;
            $newContact->email = $request->email;
            $newContact->phone = $request->phone;
            $newContact->message = $request->message;

            $newContact->save();

            return resourceCreatedResponse201($newContact, 'Contact created successfully');
        } catch (\Throwable $th) {
            return badRequestResponse400();
        }
    }

    public function getContactById($id)
    {
        try {
            $contact = $this->findOrFail($id);

            return okResponse200($contact, 'Contact retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFoundMsg);
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string',
                'email' => 'string|email',
                'phone' => 'string',
                'message' => 'string|max:400',
            ]);


            $contact = Contact::findOrFail($id);


            if ($request->has('name')) {
                $contact->name = $request->name;
            }

            if ($request->has('email')) {

                $contact->email = $request->email;
            }

            if ($request->has('phone')) {
                $contact->phone = $request->phone;
            }

            if ($request->has('message')) {
                $contact->message = $request->message;
            }

            $contact->update();

            return okResponse200($contact, 'Contact updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFoundMsg);
        }
    }


    public function destroyContact($id)
    {
        try {
            $contact = Contact::findOrFail($id);

            $contact->delete();

            return okResponse200($contact, 'Contact deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFoundMsg);
        }
    }
}
