<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; 
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name_n' => 'required|string|max:255',
            'name_s' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20', // ตรวจสอบฟิลด์ phone
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female,other',
        ]);

        $user = User::create([
            'name_n' => $request->input('name_n'),
            'name_s' => $request->input('name_s'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'), // เพิ่มฟิลด์ phone
            'password' => Hash::make($request->input('password')), // เข้ารหัสรหัสผ่านด้วย bcrypt
            'gender' => $request->input('gender'),
            'role_id' => 1, // role_id สำหรับบทบาท 'user'
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
