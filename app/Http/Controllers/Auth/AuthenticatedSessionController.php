<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create($canConnect=false, $isAdmin=false)
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'error' => session('error'),
            'canConnect' => session('canConnect'),
            'isAdmin' => session('isAdmin'),
        ]);
    }

    public function __invoke(){
        return redirect('login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if(!session('canConnect')){
            $user = User::where('email', '=', $request->email)->first();
            if($user && !$user->is_blocked){
                session()->put('canConnect', true);
                session()->put('emailConnect', $request->email);
                session()->put('isAdmin', $user->is_admin);
                return $this->create(true, $user->is_admin);
            } else if($user && $user->is_blocked) {
                return redirect()->route('login')->with('error', __('auth.blocked'));
            }
        }

        if(session('canConnect') && session('emailConnect') != $request->email){
            self::clearSessionConnect();
            return $this->create();
        }

        $request->authenticate();

        $request->session()->regenerate();

        if(str_contains(session('url.intended'), 'admin')){
            session()->forget('url.intended');
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        self::clearSessionConnect();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public static function clearSessionConnect(){
        session()->forget('canConnect');
        session()->forget('emailConnect');
        session()->forget('isAdmin');
    }
}
