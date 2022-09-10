<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request): \Inertia\Response
    {
        return Inertia::render('User/ChangePassword', [
            'user' => auth()->user()
        ]);
    }

    public function save(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back();
    }
}
