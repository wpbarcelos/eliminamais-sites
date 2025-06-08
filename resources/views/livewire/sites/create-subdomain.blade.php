<div>
    <x-modal wire:model="show">

        <x-header separator title="Criar Subdomínio"></x-header>
        <x-form wire:submit="save">

            <x-input label="Nome" wire:model="name" required />

            <x-input label="URL" wire:model="domain" required />

            <x-textarea label="Descrição para SEO"  required wire:model="description" />

            <x-button label="Cadastrar" type="submit"/>

        </x-form>

    </x-modal>
</div>
