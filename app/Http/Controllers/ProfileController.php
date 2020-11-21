<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Storage;


// ************************************
use Illuminate\Support\Str;
// ************************************

class ProfileController extends Controller
{
    // use UploadTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request)
    {
        // Form validation
        $request->validate([
            'name'              =>  'required',
            'profile_image'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current user
        $user = User::findOrFail(auth()->user()->id);
        // Set user name
        $user->name = $request->input('name');

        // Check if a profile image has been uploaded
        if ($request->has('profile_image')) {
            // Get image file
            $image = $request->file('profile_image');
            // Upload image
            $result = Storage::cloud()->putfile('/', $image);
            // Put filename in database
            $user->profile_image = $result;
        }
        // Persist user record to database
        $user->save();

        // Return user back and show a flash message
        return redirect()->back()->with(['status' => 'Profile updated successfully.']);
    }
}