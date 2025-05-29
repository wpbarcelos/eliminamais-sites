<div class="flex flex-col gap-6" x-data="{ phone: @entangle('phone') }">


    <x-header title="Cadastro" size="text-2xl" class="self-center" />

    <x-form wire:submit="register" class='md:w-1/4 self-center' no-separator>
        <x-input type="text" wire:model="name" :label="__('Name')" placeholder="Nome completo" />

        <x-input placeholder="Somente os números" wire:model="phone" :label="__('Phone')" icon-right="o-phone"
            prefix="+55" maxlength="12"
            x-on:input="phone=phone.replace(/\D/g, ''
        ).replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3' )"
            x-on:keyup="phone = phone.replace(/\D/g, '').replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3')" />

        <x-password wire:model="password" label="Senha" />

        <x-slot:actions>

            <x-button label="Voltar para o login" class="btn-ghost" link="/login" />
            <x-button type="submit" label="Cadastrar" class="btn-primary" spinner="register" />
        </x-slot:actions>
    </x-form>

</div>
