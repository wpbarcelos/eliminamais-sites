<div>
    <x-header title="Edição de Site" separator/>

    <form wire:submit.prevent="save">


        <x-button type="submit" icon="o-check" class="btn-success">Salvar</x-button>

        <x-input label="Nome" wire:model="name" />

        <x-input label="URL" wire:model="domain" />

        <x-input label="Cddigo de acesso" wire:model="codigo" />

        <div class="mt-4 mb-10">
            <h2 class='text-lg font-semibold text-center my-12'>Paginas:</h2>

            @foreach($subdomain->pages as $item)

                <x-list-item :item="$item"
                    value="title"
                    sub-value="slug"
                    link="{{ route('pages.edit', $item) }}"
                >
                <x-slot:actions>
                    <x-button icon="o-trash" class="btn-sm" wire:confirm="Excluir a pagina: '{{$item->title}}'?" wire:click="deletePage({{ $item->id }})" spinner />
                </x-slot:actions>
                </x-list-item>
            @endforeach


            <div class="flex justify-center">
                <x-button class="btn-primary my-10"
                    icon='o-plus'
                wire:click="$dispatch('create-page::show')">Nova Página</x-button>
            </div>
        </div>

    </form>

    <livewire:pages.modal-create-page :$subdomain />
</div>
