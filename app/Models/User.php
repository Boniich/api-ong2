<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    private string $modelNotFound = 'User not found';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAllUsers()
    {
        $users = $this->all();

        return okResponse200($users, 'Users retrived successfully');
    }

    public function getOneUserById($id)
    {
        try {
            $user = $this->findOrFail($id);

            return okResponse200($user, 'User retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function storeOneUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'address' => 'string',
                'profile_image' => 'image',
            ]);


            $newUser = new $this;

            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = Hash::make($request->password);

            if ($request->has('address')) {
                $newUser->address = $request->address;
            }

            if ($request->has('profile_image')) {
                $newUser->profile_image = upLoadImage($request->profile_image, 'users');
            }

            $newUser->save();

            return resourceCreatedResponse201($newUser, 'User created successfully');
        } catch (\Throwable $th) {
            return badRequestResponse400();
        }
    }

    public function updateOneUser(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string',
                'email' => 'email|unique:users',
                'password' => '',
                'address' => 'string',
                'profile_image' => 'image',
            ]);

            $user = $this->findOrFail($id);

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->has('address')) {
                $user->address = $request->address;
            }

            if ($request->has('profile_image')) {
                $user->profile_image = updateImage($user->profile_image, $request->profile_image, 'users');
            }

            $user->update();

            return okResponse200($user, 'User updated successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function destroyOneUser($id)
    {
        try {
            $user = $this->findOrFail($id);
            $image = $user->profile_image;

            $user->delete();
            destroyImage($image);

            return okResponse200($user, 'User deleted successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
