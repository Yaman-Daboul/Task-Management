<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        $userId = Auth::user()->id;
        $validated = $request->validated();
        $validated['user_id'] = $userId;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('Profiles', 'public');
            $validated['image'] = $path;
        }
        $profile = Profile::create($validated);

        return response()->json([
            'message' => 'Profile created successfully.',
            'profile' => $profile,
            'image' => $path,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $profile = Profile::where('user_id', $id)->firstOrFail();

        return response()->json($profile, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, int $id)
    {
        // $profile = Profile::query()->find($id);
        $profile = User::find($id)->profile;
        if ($profile) {
            $profile->update($request->validated());

            return response()->json($profile);
        } else {
            return response()->json(['message' => 'Please Enter a valid id'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
    // public function update(UpdateProfileRequest $request, ?int $userId = null)
    // {
    //     $currentUser = auth()->user();

    //     if ($userId && $currentUser->role === 'admin') {
    //         $userToUpdate = User::findOrFail($userId);
    //     } else {
    //         $userToUpdate = $currentUser;
    //     }

    //     $userToUpdate->profile()->update(
    //         $request->validated()
    //     );

    //     return response()->json([
    //         'message' => 'Profile updated successfully',
    //         'data' => $userToUpdate->load('profile')
    //     ]);
    // }
}
