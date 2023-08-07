<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title= "ONG API by Boniich",
 *      description="I make this API to youtube",
 * )
 */

class ContactController extends Controller
{
    private $contacts;

    public function __construct(Contact $contact)
    {
        $this->contacts = $contact;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/contacts",
     *      tags={"Contacts"},
     *      summary="Display a list of contacts",
     *      @OA\Response(
     *          response=200,
     *          description="Contacts retrived successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="string", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Julieta Diaz",
     *                          "email": "juli@gmail.com",
     *                          "phone": "1222222",
     *                          "message": "Hola soy juli!",
     *                      }}),
     *              @OA\Property(property="message", type="string", format="string", example="Contacts retrived successfully"),
     *      ),
     *      )
     *  )
     * 
     */

    public function index()
    {
        return $this->contacts->getAllContacts();
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/contacts",
     *      tags={"Contacts"},
     *      summary="Create a new contact",
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          required={"name","email","phone","message"},
     *          @OA\Property(property="id", type="integer", format="string"),
     *          @OA\Property(property="name", type="string", format="string"),
     *          @OA\Property(property="email", type="string", format="string" ),
     *          @OA\Property(property="phone", type="string", format="string"),
     *          @OA\Property(property="message", type="string", format="string"),
     *      ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Contact created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Julieta Diaz",
     *                          "email": "juli@gmail.com",
     *                          "phone": "1222222",
     *                          "message": "Hola soy juli!",
     *                      }),
     *              @OA\Property(property="message", type="string", format="string", example="Contact created successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Bad Request"),
     *          ),  
     *      )
     *   )
     * 
     */

    public function store(Request $request)
    {
        return $this->contacts->storeContacts($request);
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/contacts/{id}",
     *      tags={"Contacts"},
     *      summary="Display a contact by id",
     *  
     *      @OA\Parameter(
     *          description="id of contact",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Contact retrived successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Julieta Diaz",
     *                          "email": "juli@gmail.com",
     *                          "phone": "1222222",
     *                          "message": "Hola soy juli!",
     *                      }),
     *              @OA\Property(property="message", type="string", format="string", example="Contact retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Contact not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Contact not found"),
     *          ),
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->contacts->getContactById($id);
    }


    /**
     *  @OA\Put(
     *      path="/api/v1/contacts/{id}",
     *      tags={"Contacts"},
     *      summary="Update a contact by id",
     * 
     *      @OA\Parameter(
     *          description="id of contact",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          @OA\Property(property="id", type="integer", format="string"),
     *          @OA\Property(property="name", type="string", format="string"),
     *          @OA\Property(property="email", type="string", format="string" ),
     *          @OA\Property(property="phone", type="string", format="string"),
     *          @OA\Property(property="message", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Contact updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Julieta Diaz",
     *                          "email": "juli@gmail.com",
     *                          "phone": "1222222",
     *                          "message": "Hola soy juli!",
     *                      }),
     *              @OA\Property(property="message", type="string", format="string", example="Contact updated successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Contact not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Contact not found"),
     *          ),
     *      )
     *  )
     */


    public function update(Request $request, $id)
    {
        return $this->contacts->updateContact($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/contacts/{id}",
     *      tags={"Contacts"},
     *      summary="Delete a contact",
     * 
     *      @OA\Parameter(
     *          description="id of contact",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Contact deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Julieta Diaz",
     *                          "email": "juli@gmail.com",
     *                          "phone": "1222222",
     *                          "message": "Hola soy juli!",
     *                      }),
     *              @OA\Property(property="message", type="string", format="string", example="Contact deleted successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Contact not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Contact not found"),
     *          ),
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->contacts->destroyContact($id);
    }
}
