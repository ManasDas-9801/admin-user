<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index() {
        $data['users'] = User::where('is_admin','!=', '1')->orderBy('id', 'DESC')->get();
        return view('users.index', $data);
    }
    public function create () {
        return view('users.create');
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'country' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($request->hasFile('photo')) {
                $imageName = time().'.'.$request->photo->extension();

                // Public Folder
                $request->photo->move(public_path('images'), $imageName);
            } else {
                $photoPath = null;
            }
            $user = new User([
                'name' => $request->input('first_name').' '.$request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'photo' => $imageName,
            ]);
            $user->save();
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
            Mail::to($request->input('email'))->send(new UserMail($data));

            return response()->json(['message' => 'Registration successful']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
    public function edit($id) {
        $data['user'] = User::whereId($id)->first();
        return view('users.edit', $data);
    }
    public function update(Request $request) {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'country' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
            ]);
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('public/uploads/users');
            } else {
                $photoPath = null;
            }
            $user = User::where('email', $request->input('email'))->first();

            $user->update($request->except('password'));
            $user->save();
            return response()->json(['message' => 'User Update successful']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('all.user')->with('success', 'User deleted successfully.');
    }
    public function toggleActive(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        if($user->is_active == '0') {
            $user->is_active = '1'; // Toggle the value
            
        }
        else{
            $user->is_active = '0'; // Toggle the value
        }
        $user->save();

        return response()->json(['message' => 'Status updated successfully', 'is_active' => $user->is_active]);
    }
    
}
