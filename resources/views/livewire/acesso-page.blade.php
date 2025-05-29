<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10 text-center">
        <h1 class="text-2xl font-bold">{{ $subdomain?->name ?: 'Acesso a plataforma'}}</h1>
    </div>


    <x-form wire:submit="login">
        <x-password placeholder="Informe o codigo de acesso" wire:model="codigo" type="password" />

        <x-slot:actions>
            {{-- <x-button label="Criar conta" class="btn-ghost" link="/registro" /> --}}
            <x-button label="Entrar" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>

</div>
