<div class="md:w-96 mx-auto mt-20" x-data="{ phone: @entangle('phone') }">
    <div class="mb-10 text-center">
        Login
    </div>


    <x-form wire:submit="login">
        <x-input placeholder="Telefone" wire:model="phone" icon="o-phone" prefix="+55" maxlength="12"
            x-on:input="phone=phone.replace(/\D/g, ''
            ).replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3' )"
            x-on:keyup="phone = phone.replace(/\D/g, '').replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3')" />

        <x-input placeholder="Senha" wire:model="password" type="password" icon="o-key" />

        <x-slot:actions>
            <x-button label="Criar conta" class="btn-ghost" link="/registro" />
            <x-button label="Entrar" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>

    {{--

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif --}}
</div>
