<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //Display a listing of the resource.
    public function index()
    {
        $users = User::where('disabled', false)->get();

        return response()->json([
            'message' => 'Get all users',
            'data' => $users
        ]);
    }


    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validating the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
/*             'birth_date' => 'required' */
        ]);

        //Store the data
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Store data',
            'data' => $user
        ], 201);
    }

    //Display the specified resource.
    public function show(string $id)
    {
        $user = User::find($id);

        return response()->json([
            'message' => 'Get user by id',
            'data' => $user
        ]);
    }

    //Update the specified resource in storage.
    public function update(Request $request, User $user)
    {
        return response()->json([
            'message' => 'Nothing to update'
        ]);
    }

    //Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->disabled = true;
        $user->save();

        return response()->json([
            'message' => 'Disabled the user',
            'data' => $user
        ]);        
    }
}
