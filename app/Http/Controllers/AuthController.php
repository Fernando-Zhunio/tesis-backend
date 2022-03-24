<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
         
        // throw ValidationException::withMessages([
        //     'password' => [$request->password]
        // ]);
        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(50);
            $token->save();
        }

        $user->assignRole('user');

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function signUp(Request $request)
    {
        $dateMayor =  Carbon::now()->subYears(18)->format('d/m/Y');
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'birthday' => 'required|date_format:d/m/Y|before:'.$dateMayor,
            'is_student' => 'required|boolean',
            'password' => 'required|string|confirmed'
        ]);
        $date = str_replace('/', '-', $request->birthday);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => Carbon::parse($date)->format('Y-m-d H:i:s'),
            'is_student' => $request->is_student,
            'password' => bcrypt($request->password)
        ]);

        $user->assignRole('user');

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
}
