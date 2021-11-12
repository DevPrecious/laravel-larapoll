<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $user = User::find(auth()->id());
        return view('profile.index', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $dataToSave = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $request->validate([
                'password' => ['required', Rules\Password::defaults()],
            ]);
            $dataToSave['password'] = Hash::make($request->password);
        }

        User::find(auth()->id())->update($dataToSave);

        if (!empty($request->hasFile('image'))) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('profiles'), $imageName);

            $profileData = [
                'user_id' => auth()->id(),
                'image' => $imageName
            ];

            $profile = Profile::where('user_id', auth()->id())->first();
            if (empty($profile)) {
                Profile::create($profileData);
            } else {
                Profile::where('user_id', auth()->id())->first()->update($profileData);
            }
        }

        return back()->with('success', 'Profile Updated.');
    }
}
