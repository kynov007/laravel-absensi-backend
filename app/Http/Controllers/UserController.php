<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index
    public function index()
    {
        //search by name, pagination 10
        
        $users = User::where('name', 'like', '%' . request('name') . '%')
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('pages.users.index', compact('users'));
    }
    //create
    public function create()
    {
        return view('pages.users.create');
    }
    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'cuti' => $request->cuti,
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    // //edit
    // public function edit(User $user)
    // {
    //     return view('pages.users.edit', compact('user'));
    // }
    //edit
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }
    //update
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        //if password filled
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    //destroy
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
