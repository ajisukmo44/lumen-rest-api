<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mime\Message;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function register(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $hashpassword = Hash::make($password);

        $user = User::create(['email' => $email, 'password' => $hashpassword]);

        return response()->json(["Message" => "successs", 201]);
    }


    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);


        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user) {

            return response()->json(["Message" => "login gagal", 401]);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(["Message" => "login gagal", 401]);
        }

        $generatetoken = bin2hex(random_bytes(40));
        $user->update(['token' => $generatetoken]);

        return response()->json($user);
    }

    //
}
