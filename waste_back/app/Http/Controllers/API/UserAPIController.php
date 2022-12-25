<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Auth;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{


    /**
     * Store a newly created User in storage.
     * POST /usersModels
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('soum_district:id,name')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->token = $user->createToken('token')->plainTextToken;

        return  Response::json($user->toArray(), 200, [], JSON_UNESCAPED_SLASHES);
    }


    /**
     * Store a newly created User in storage.
     * POST /usersModels
     *
     * @return Response
     */
    public function save_token(Request $request)
    {
        $request->validate([
            'push_token' => 'required|string',
        ]);

        Auth::user()->push_token = $request->push_token;
        Auth::user()->save();

        return new JsonResponse('success');
    }
}
