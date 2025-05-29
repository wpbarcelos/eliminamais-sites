<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10 text-center">
        Login - admin
    </div>

    <x-form wire:submit="login">
        <x-input placeholder="seumail@mail.com" wire:model="email" icon="o-user" />
        <x-password placeholder="Senha" wire:model="password" type="password" />

        <x-slot:actions>
            {{-- <x-button label="Criar conta" class="btn-ghost" link="/registro" /> --}}
            <x-button label="Entrar" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>

</div>
