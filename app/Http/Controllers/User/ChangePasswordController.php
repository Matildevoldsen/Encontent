<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CheckPasswordMatchesCurrent;
use App\Rules\NotFromPasswordHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
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
        $this->validate($request, [
            'old_password' => [
                'required',
                new CheckPasswordMatchesCurrent()
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                new NotFromPasswordHistory($request->user(), 5),
            ]
        ]);
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back();
    }
}
