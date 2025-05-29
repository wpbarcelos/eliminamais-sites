<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string')]
    public string $phone = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public string $error = '';

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {

        $this->validate();

        // dd($this->password, $this->phone);
        // $this->ensureIsNotRateLimited();

        ds()->info($this->phone, $this->password);

        $user = User::query()->where('phone', '+55' . $this->phone)
            ->where('password', $this->password)
            ->first();

        if (! $user) {
            $this->addError('password', 'Credenciais inválidas');

            return;
        }
        Auth::loginUsingId($user->id);

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

        // if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
        //     RateLimiter::hit($this->throttleKey());

        //     throw ValidationException::withMessages([
        //         'email' => __('auth.failed'),
        //     ]);
        // }

        // RateLimiter::clear($this->throttleKey());
        // Session::regenerate();

        // $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
