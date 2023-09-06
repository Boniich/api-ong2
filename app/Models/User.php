<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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

    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getAllUsers()
    {
        $users = $this->all();

        foreach ($users as $key => $value) {
            $value->slides;
            $value->activities;
            $value->news;
            $value->comments;
        }

        return okResponse200($users, 'Users retrived successfully');
    }

    public function getOneUserById($id)
    {
        try {
            $user = $this->findOrFail($id);

            $user->slides;
            $user->activities;
            $user->news;
            $user->comments;

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

            $newUser->assignRole(2)->save();

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

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $user = new $this;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->assignRole(2)->save();

            return okResponse200($user, 'User register successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($credentials->fails()) {
                throw new BadRequestException;
            }

            if (!Auth::attempt($credentials->getData())) {
                throw new AuthenticationException;
            }

            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(['success' => true, 'data' => $user, 'token' => $token, 'message' => 'Login successfully']);
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (AuthenticationException $th) {
            return response()->json(errorResponse('Invalid Credentials'), 401);
        }
    }
}
