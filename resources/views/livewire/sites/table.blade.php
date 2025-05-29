<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    @foreach($this->data as $item)

        <x-list-item :item="$item" value="name" sub-value="domain"
            link="{{ route('sites.edit', $item->id) }}"
        >
            <x-slot:actions>
                <x-button icon="o-trash" class="btn-sm" wire:confirm="Deseja realmente excluir a pagina?" wire:click="delete({{ $item->id }})" spinner />
            </x-slot:actions>
        </x-list-item>


    @endforeach
</div>
