<?php

namespace App\Http\Controllers\Api\Pos;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //create user customer`1
    public function createCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user = new User();
        $user->company_id = 1;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = 'enable';
        $user->user_type = 'customer';
        //$user->login_enabled = 1;
        $user->is_superadmin = 0;
        //$user->role_id = 3;
        $user->username = $request->email;

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully',
            'data' => $user
        ], 201);
    }

    //get user customer
    public function getCustomer()
    {
        $users = User::where('user_type', 'customer')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Customers retrieved successfully',
            'data' => $users
        ], 200);
    }
}
