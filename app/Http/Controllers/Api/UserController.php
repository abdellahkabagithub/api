<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(
            $users
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateDonnees = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $users = User::create([
            "name" => $validateDonnees["name"],
            "email" => $validateDonnees["email"],
            "password" =>bcrypt($validateDonnees["password"])
        ]);

        return response()->json($users,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            "name" => "required|max:100",
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password
        ]);

        return response()->json();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json();
    }

    public function connexion(Request $request) {
        $this->validate($request,[
            "email" => "required|email",
            "password" => "required"
        ]);

        $users = User::where("email", $request->email)->first();
        if(!$users) return response(["message" => "Desolé cet Utilisateur n'existe pas ! "]);
        if(!Hash::check($request->password,$users->password)){
            response()->json(["message" => "Cet mot de pass ne correspond pas à cet User !"]);
        }
        $token = $users->createToken('CLE_SECRETE')->plainTextToken ;
        return response([
            "users" => $users,
            "token" => $token
        ], 200);
    }
    
}
