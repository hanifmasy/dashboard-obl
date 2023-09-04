<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Validator;


class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request){

      $rules = [
            'nama_lengkap' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
       ];

       $customMessages = [
           'required' => ':attribute harus diinput.',
           'username.unique' => 'Username Sudah Dipakai.',
           'email.unique' => 'Email Sudah Dipakai.',
           'password.min' => 'Password harus minimal 5 karater.'
       ];

       $attributes = $this->validate($request, $rules, $customMessages);

        // $attributes = request()->validate([
        //     'nama_lengkap' => 'required|max:255',
        //     'username' => 'required|max:255|unique:users,username',
        //     'email' => 'required|email|max:255|unique:users,email',
        //     'password' => 'required|min:5|max:255',
        // ]);

        $user = User::create($attributes);
        return redirect('/sign-in')->with('status','Silahkan Hubungi Admin Untuk Memilih Role Akses Anda.');
    }
}
