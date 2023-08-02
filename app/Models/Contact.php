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

    private function successResponse(object $data, string $message)
    {
        return ['success' => true, 'data' => $data, 'message' => $message];
    }

    private function errorResponse(string $message)
    {
        return ['success' => false, 'error' => $message];
    }

    public function getAllContacts()
    {
        $contacts = $this->all();

        return response()->json($this->successResponse($contacts, 'Contacts retrived successfully'), 200);
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

            return response()->json($this->successResponse($newContact, 'Contact created successfully'), 201);
        } catch (\Throwable $th) {
            return response()->json($this->errorResponse('Bad Request'), 400);
        }
    }

    public function getContactById($id)
    {
        try {
            $contact = $this->findOrFail($id);

            return response()->json($this->successResponse($contact, 'Contact retrived successfully'), 200);
        } catch (ModelNotFoundException $th) {
            return response()->json($this->errorResponse($this->modelNotFoundMsg), 404);
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

            return response()->json($this->successResponse($contact, 'Contact updated successfully'));
        } catch (ModelNotFoundException $th) {
            return response()->json($this->errorResponse($this->modelNotFoundMsg));
        }
    }


    public function destroyContact($id)
    {
        try {
            $contact = Contact::findOrFail($id);

            $contact->delete();

            return response()->json($this->successResponse($contact, 'Contact deleted successfully'));
        } catch (ModelNotFoundException $th) {
            return response()->json($this->errorResponse($this->modelNotFoundMsg));
        }
    }
}
