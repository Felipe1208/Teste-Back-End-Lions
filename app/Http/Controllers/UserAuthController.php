<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $data['password'] = Hash::make($request->password);

        $data = User::create($data);

        return response()->json([$data->toArray()]);
    }
}
