<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'username' => 'NO USER EXISTS.'
            ]);
        }
        $is_user = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
        ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
        ->where('users.id',Auth::user()->id)
        ->first();
        if( !$is_user->role_id ){
          throw ValidationException::withMessages([
              'user_role' => 'Akun Anda Belum Memiliki Akses Role.'
          ]);
        }

        session()->regenerate();
        return redirect('/dashboard');
        // return redirect('inputs');
    }

    public function show(){
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }

    public function update(){

        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/sign-in');
    }

}
