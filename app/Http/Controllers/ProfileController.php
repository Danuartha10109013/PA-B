<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($id){
        $data = User::find($id);
        return view('pages.profile.index',compact('data'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'acuan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gender' => 'nullable',
            'no_wa' => 'nullable',
            'tempat_lahir' => 'nullable',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's basic info
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->no_wa = $request->no_wa;
        $user->birthday = $request->birthday;
        $user->alamat = $request->alamat;

        // Handle password update (if provided)
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete the old profile picture if it exists
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
    
            // Store the new profile picture
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->profile = $avatarPath;
        }
        if ($request->hasFile('acuan')) {
            // Delete the old profile picture if it exists
            if ($user->acuan) {
                Storage::disk('public')->delete($user->acuan);
            }
    
            // Store the new profile picture
            $avatarPath = $request->file('acuan')->store('acuan', 'public');
            $user->acuan = $avatarPath;
        }

        // Save the updated user details
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }



}

