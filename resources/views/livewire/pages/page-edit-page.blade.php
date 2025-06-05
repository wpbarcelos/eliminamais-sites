<div>
    <x-header title="Edição de Página" separator subtitle="Site: {{ $page?->subdomain->name }}"/>



    <form wire:submit="update">

        <x-button type="submit" class="btn-success">Salvar</x-button>

        <x-input label="Titulo da página" wire:model="title"/>

        <x-input label="URL amigavel" wire:model="slug"/>


        <x-file label="Imagem principal" wire:model="file_image" accept="image/png, image/jpeg">

            <img src="{{ $page->image
                          ? Storage::url($page->image)
                          : $file_image}}"
                class="w-100 h-64 rounded-lg bg-black" />
        </x-file>


        <x-file label="Ícone da imagem" wire:model="file_icon" accept="image/png, image/jpeg">

            <img src="{{ $page->image_icon
                          ? Storage::url($page->image_icon)
                          : $file_icon}}"
                 class="w-32 h-32 rounded-lg bg-black" />
        </x-file>


        <h3 class="font-bold mt-6 mb-2">Componentes</h3>

        @php
            $options = [
                ['id'=> 'video','name'=>'Video'],
                ['id'=> 'textolivre','name'=>'Texto Livre'],
                ['id'=> 'imagem','name'=>'Imagem'],
            ];
        @endphp

        @foreach($components as $i => $component)

            <div wire:key={{ 'component_item_'.$i }}
                 class="p-4 border rounded mb-4
                @if($components[$i]['type'] == 'video')  bg-zinc-900 @endif
                @if($components[$i]['type'] == 'imagem')  bg-slate-900 @endif
                @if($components[$i]['type'] == 'video')  bg-blue-900 @endif
            ">
                <x-select
                    label="Tipo"
                    wire:model.live="components.{{ $i }}.type"
                    :options="$options"
                />

                @if($component['type'] === 'video')
                    <x-input label="URL do vídeo" wire:model.defer="components.{{ $i }}.data.url" />
                    <x-input label="Descrição" wire:model.defer="components.{{ $i }}.data.description" />
                @elseif($component['type'] === 'textolivre')
                    <x-editor label="Conteúdo" wire:model.defer="components.{{ $i }}.data.content" />
                @elseif($component['type'] === 'imagem')

                    @php $urlImageComponent = $component['data']['url']; @endphp


                    <div class="mt-2">
                        <div wire:loading class="h-40  min-w-40 object-cover block rounded-lg bg-black/25" >
                            Carregando imagem...
                        </div>
                        <div wire:loading.remove>
                            <x-file wire:key="file-image-{{ $i }}" wire:model.live="components.{{ $i }}.data.file" accept="image/png, image/jpeg">
                                <img src="{{ $urlImageComponent
                                                        ? Storage::url($urlImageComponent)
                                                        : $components[$i]['data']['file'] }}"
                                    class="h-40  min-w-40 object-cover block rounded-lg bg-black " />
                            </x-file>
                        </div>
                    </div>

                    {{-- <x-input label="Legenda" wire:model.defer="components.{{ $i }}.data.caption" /> --}}
                @endif


                <div class="flex gap-2 mt-2">
                    <x-mary-button type="button" wire:click="moveComponentUp({{ $i }})" :disabled="$i === 0">
                        ↑
                    </x-mary-button>
                    <x-mary-button type="button" wire:click="moveComponentDown({{ $i }})" :disabled="$i === count($components) - 1">
                        ↓
                    </x-mary-button>

                    <x-mary-button title="Remover componente" class="ml-auto" type="button" wire:confirm="Deseja realmente excluir o componente?" wire:click="removeComponent({{ $i }})" color="danger" icon="o-trash">
                        Remover
                    </x-mary-button>
                </div>
            </div>
        @endforeach

        <x-mary-button type="button" wire:click="addComponent" class="mb-4">
            Adicionar Componente
        </x-mary-button>

    </form>
</div>
