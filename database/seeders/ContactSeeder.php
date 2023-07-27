<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contact = new Contact();

        $contact->id = 1;
        $contact->name = 'Fernando';
        $contact->email = 'fernando@gmail.com';
        $contact->phone = '12345678';
        $contact->message = 'Hola desde el archivo de seeders';

        $contact->save();
    }
}
