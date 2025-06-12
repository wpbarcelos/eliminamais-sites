<div>
    <x-header title="Edição de Página" separator subtitle="Site: {{ $page?->subdomain->name }}"/>



    <form wire:submit="update">

        <div class="flex justify-between">
            <x-button type="submit" class="btn-success">Salvar</x-button>
            <x-button link="{{  $link }}"  external class="btn-secondary">Abrir Página</x-button>
        </div>

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

        <x-input label="Texto do bullet" wire:model="text_bullet" required/>


        <h3 class="font-bold mt-6 mb-2">Componentes</h3>

        @php
            $options = [
                ['id'=> 'video','name'=>'Video'],
                ['id'=> 'textolivre','name'=>'Texto Livre'],
                ['id'=> 'imagem','name'=>'Imagem'],
                ['id'=> 'file','name'=>'Arquivo'],
            ];
        @endphp

        @foreach($components as $i => $component)

            <div wire:key={{ 'component_item_'.$i }}
                 class="p-4 border rounded mb-4
                @if($components[$i]['type'] == 'textolivre')  bg-yellow-100 @endif
                @if($components[$i]['type'] == 'video')  bg-zinc-200 @endif
                @if($components[$i]['type'] == 'imagem')  bg-slate-200 @endif
                @if($components[$i]['type'] == 'video')  bg-blue-200 @endif
                @if($components[$i]['type'] == 'file') bg-green-200 @endif

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


                    @php $urlImageComponent = $component['data']['url'] ?: null; @endphp


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

                @elseif($component['type'] === 'file')
                    <x-input label="Nome do arquivo (opcional)" wire:model.live="components.{{ $i }}.data.name" />
                    <x-input label="Descrição" wire:model.defer="components.{{ $i }}.data.description" />

                    @php $urlFile = data_get($component, 'data.url'); @endphp
                    <div class="mt-2">
                        <div wire:loading>
                            Carregando arquivo...
                        </div>
                        <div wire:loading.remove>
                            <x-file wire:key="file-{{ $i }}" wire:model.live="components.{{ $i }}.data.file" accept="*/*" />
                        </div>

                        @if($urlFile)
                            <a href="{{ Storage::url($urlFile) }}" target="_blank" class="text-blue-500 underline">Visualizar arquivo</a>
                        @endif
                    </div>
                    
                    

                    {{-- <div class="mt-2">
                        <div wire:loading class="p-4 border rounded bg-gray-100">
                            Carregando arquivo...
                        </div>
                        <div wire:loading.remove>
                            <x-file wire:key="file-upload-{{ $i }}" wire:model.live="components.{{ $i }}.data.file">
                                @if( $urlFile )
                                    <div class="p-4 border rounded bg-gray-50">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                          
                                            <a href="{{ Storage::url($urlFile) }}" target="_blank" class="ml-auto text-blue-600 hover:text-blue-800">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-8 border-2 border-dashed border-gray-300 rounded text-center">
                                        <p class="text-gray-500">Selecione um arquivo</p>
                                    </div>
                                @endif
                            </x-file>
                        </div>
                    </div> --}}
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
