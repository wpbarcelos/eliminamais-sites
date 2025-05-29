<div>
    <x-modal wire:model="modal">
        <x-slot name="title">
            Nova Pagina
        </x-slot>
        <x-form>
            <x-input label="Nome" wire:model="title" />

            <x-input label="URL" wire:model="slug" />

            <x-slot name="actions">
                <x-button wire:click="save" spinner>
                    Salvar
                </x-button>
            </x-slot>

        </x-form>

    </x-modal>


</div>
