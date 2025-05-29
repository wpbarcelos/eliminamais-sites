<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $phone = '';

    public string $password = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'lowercase', 'max:14', 'regex:/^\(\d{2}\)\d{5}-\d{4}$/', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:6', 'max:30'],
        ]);

        // $validated['password'] = Hash::make($validated['password']);

        // $user = User::create($validated)

        $validated['phone'] = '+55'.$validated['phone'];
        $validated['is_active'] = true;

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
