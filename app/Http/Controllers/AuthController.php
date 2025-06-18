<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AddressDetails;
use App\Models\detailUser;
use App\Models\User;
use App\Models\UserDetails;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @group Authentication
 *
 * APIs for managing user authentication
 */
class authController extends Controller
{
    /**
     * Login a user
     *
     * Authenticate a user with their email and password, and return an access token.
     *
     * @bodyParam email string required The email address of the user. Example: user@example.com
     * @bodyParam password string required The password of the user. Example: password123
     *
     * @response 200 {
     *  "access_token": "abcdefg123456",
     *  "token_type": "bearer",
     *  "expires_at": "2024-11-23 00:00:00",
     *  "expires_in": "30 days, 0 hours, 0 minutes, 0 seconds",
     *  "user": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "email": "user@example.com"
     *  }
     * }
     * @response 401 {
     *  "error": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $tokenResult = auth()->user()->createToken(Carbon::now()->toDateTimeString());
            $accessToken = $tokenResult->accessToken;
            $expiresAt = $tokenResult->token->expires_at;
            $expiresIn = Carbon::parse($expiresAt)->diff(now())->format('%d days, %h hours, %i minutes, %s seconds');

            return $this->respondWithToken([
                'token' => $accessToken,
                'user' => User::where("id",Auth()->id())->first(),
                'expires_at' => $expiresAt,
                'expires_in' => $expiresIn,
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'role' => 'required',
        ]);

        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // set default detail_user
        detailUser::create([
            'user_id' => $user->id,
            'nik' => $request->nik ?? '',
            'pekerjaan' => $request->pekerjaan ?? '',
            'tanggal_lahir' => Carbon::now(),
            'umur' => $request->umur ?? 0,
            'alamat' => $request->alamat ?? '',
            'jenis_kelamin' => 'L',
            'no_telepon' => '0000000000',
            'foto' => '/images/profile/default.png',
        ]);


        $user->assignRole($request->role ?? 'user');

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);

    }

    /**
     * Get Authenticated User
     *
     * Retrieve details of the currently authenticated user.
     *
     * @response 200 {
     *  "id": 1,
     *  "name": "John Doe",
     *  "email": "user@example.com"
     * }
     * @response 401 {
     *  "error": "Unauthorized"
     * }
     */
    public function me()
    {
        $user = User::where("id",Auth()->id())->first();
        if ($user) {
            return response()->json($user->with(['roles', 'permissions','detail_user'])->first());
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function forget_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        //$user->sendPasswordResetNotification(Password::createToken($user));
        $cek = DB::table('password_reset_tokens')->where('email', $user->email)->first();
        if ($cek) {
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        }
        $token = Str::random(100);
        DB::table('password_reset_tokens')->insertGetId([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $eksternal_url = env('EXTERNAL_URL');
        $url = $eksternal_url . '/auth/reset-password?email=' . $user->email . '&token=' . $token;
        // Mail::send('emails.forgot_password', ['url' => $url], function ($message) use ($user) {
        //     $message->to($user->email);
        //     $message->subject('Reset Password');
        //     $message->from('laravel@gmail.com', 'Laravel');
        // });

        Mail::send('emails.reset_password', ['token' => $token, 'url' => $url], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password');
            $message->from('laravel@gmail.com', 'Laravel');
        });
        return response()->json([
            'message' => 'Password reset link sent to your email.',
            'token' => $token
        ]);
    }



    public function reset_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $token = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        if (!$token) {
            return response()->json(['error' => 'Invalid token'], 400);
        }


        $user = User::where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
        return response()->json([
            'message' => 'Password reset successfully.',
        ]);
    }

    public function reset_password_view(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
                            ->where([
                                'email' => $request->email,
                                'token' => $request->token
                            ])
                            ->first();
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }


        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

        return redirect()->to('https://example.com/login')->with('success', 'Password reset successfully.');
    }

    /**
     * Logout a user
     *
     * Revoke the current user's access token and log them out.
     *
     * @response 200 {
     *  "message": "Successfully logged out"
     * }
     * @response 401 {
     *  "error": "Unauthorized"
     * }
     */
    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $request->user()->token()->revoke();
            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Refresh Token
     *
     * Revoke the current token and issue a new one.
     *
     * @response 200 {
     *  "access_token": "newtoken123456",
     *  "token_type": "bearer",
     *  "expires_at": "2024-11-23 00:00:00",
     *  "expires_in": "30 days, 0 hours, 0 minutes, 0 seconds",
     *  "user": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "email": "user@example.com"
     *  }
     * }
     * @response 401 {
     *  "error": "Unauthorized"
     * }
     */
    public function refresh(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->where('id', $user->token()->id)->delete();
            $tokenResult = $user->createToken('PassportAuth');
            $accessToken = $tokenResult->accessToken;
            $expiresAt = $tokenResult->token->expires_at;
            $expiresIn = Carbon::parse($expiresAt)->diff(now())->format('%d days, %h hours, %i minutes, %s seconds');

            return $this->respondWithToken([
                'token' => $accessToken,
                'user' => $user,
                'expires_at' => $expiresAt,
                'expires_in' => $expiresIn,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Format response with token
     *
     * Internal method to format the token response.
     */
    private function respondWithToken($response)
    {
        return response()->json([
            "access_token" => $response["token"],
            "token_type" => "bearer",
            "expires_at" => $response["expires_at"]->toDateTimeString(),
            "expires_in" => $response["expires_in"],
            "user" => $response["user"]
        ]);
    }
}
