<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Validator;

class UserController extends Controller
{
    public function __construct() {
        $this->user = new User;
    }

    public function index()
    {
        $users = $this->user->paginate(10);

        return view('user.index')->with( 'users', $users );
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|string|unique:users,email|email',
            'password'=>'required|string'
        ]);

        $user = $this->user->create([
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        return redirect('/')->with('success', 'Saved');
    }

    public function delete($id)
    {
        $user = $this->user->find($id);

        if ( empty( $user ) ) {
            return redirect('/')->with('error', 'No user found');
        }

        $user->delete();
        return redirect('/')->with('success', 'Post Removed');
    }
}
