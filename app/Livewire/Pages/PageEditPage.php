<?php

namespace App\Livewire\Pages;

use App\Models\Page;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class PageEditPage extends Component
{

    use Toast;

    use WithFileUploads;

    public ?Page $page;

    #[Validate('required|string|max:255')]
    public string $title;

    #[Validate('required|string|min:3|max:255')]
    public string $slug;

    #[Validate('nullable|image|max:2048')]
    public $file_image;

    #[Validate('nullable|image|max:1024')]
    public $file_icon;


    public $components;


    public $link;


    public function mount(Page $page)
    {
        $this->page  = $page;

        $this->page->load('components');

        $this->title = $page->title ?? '';
        $this->slug = $page->slug;

        $this->link = 'https://' . $page->subdomain->domain . '/' . $page->slug;


        $this->components = $page->components->map(function ($component) {
            return [
                'id' => $component->id,
                'type' => $component->type,
                'data' => [...$component->componentable->toArray(), 'file' => null, 'caption' => ''],
            ];
        })->toArray();
    }


    public function addComponent()
    {
        $this->components[] = [
            'type' => 'textolivre', // valor padrão, pode ser 'video' ou 'imagem'
            'data' => [
                'url' => '',
                'file' => null,
                'description' => '',
                'content' => '',
                'caption' => '',
            ],
        ];
    }


    public function moveComponentUp($index)
    {
        if ($index > 0) {
            $temp = $this->components[$index - 1];
            $this->components[$index - 1] = $this->components[$index];
            $this->components[$index] = $temp;
        }
    }

    public function moveComponentDown($index)
    {
        if ($index < count($this->components) - 1) {
            $temp = $this->components[$index + 1];
            $this->components[$index + 1] = $this->components[$index];
            $this->components[$index] = $temp;
        }
    }

    public function removeComponent($index)
    {
        array_splice($this->components, $index, 1);
    }

    public function update()
    {
        $this->validate();

        // Upload da imagem principal
        if ($this->file_image instanceof \Illuminate\Http\UploadedFile) {
            // Remove a imagem antiga, se existir
            if ($this->page->image) {
                Storage::disk('public')->delete($this->page->image);
            }
            $this->page->image = $this->file_image->store('images', 'public');
        }

        // Upload do ícone
        if ($this->file_icon instanceof \Illuminate\Http\UploadedFile) {
            if ($this->page->image_icon) {
                Storage::disk('public')->delete($this->page->image_icon);
            }
            $this->page->image_icon = $this->file_icon->store('images', 'public');
        }

        $this->page->title = $this->title ?? '';
        $this->page->slug = $this->slug;
        $this->page->save();


        // IDs dos componentes existentes (para saber quais remover)
        $existingComponentIds = $this->page->components->pluck('id')->toArray();
        $submittedComponentIds = collect($this->components)->pluck('id')->filter()->toArray();

        // Remove componentes que foram excluídos no formulário
        $toDelete = array_diff($existingComponentIds, $submittedComponentIds);
        if (!empty($toDelete)) {
            foreach ($toDelete as $id) {
                $component = $this->page->components()->find($id);
                if ($component) {
                    $component->componentable()->delete();
                    $component->delete();
                }
            }
        }

        // Atualiza ou cria componentes
        foreach ($this->components as $order => $compData) {
            $order += 1;



            if ($compData['type'] === 'imagem') {
                // Verifica se é um componente existente
                $component = isset($compData['id'])
                    ? $this->page->components()->find($compData['id'])
                    : null;

                // Se houver novo upload
                if (isset($compData['data']['file']) && $compData['data']['file'] instanceof \Illuminate\Http\UploadedFile) {
                    // Remove a foto antiga, se existir
                    if ($component && $component->componentable && $component->componentable->url) {
                        Storage::disk('public')->delete($component->componentable->url);
                    }

                    // Faz o upload da nova imagem
                    $path = $compData['data']['file']->store('images', 'public');
                    $compData['data']['url'] = $path;
                } elseif ($component) {
                    // Se não houver novo upload, mantém a url antiga
                    $compData['data']['url'] = $component->componentable->url;
                }

                // Remove o campo 'file' para não tentar salvar no banco
                unset($compData['data']['file']);
            }

            // Lógica para componente do tipo 'file'
            if ($compData['type'] === 'file') {
                // Verifica se é um componente existente
                $component = isset($compData['id'])
                    ? $this->page->components()->find($compData['id'])
                    : null;

                // Se houver novo upload
                if (isset($compData['data']['file']) && $compData['data']['file'] instanceof \Illuminate\Http\UploadedFile) {
                    // Remove o arquivo antigo, se existir
                    if ($component && $component->componentable && $component->componentable->url) {
                        Storage::disk('public')->delete($component->componentable->url);
                    }

                    // Faz o upload do novo arquivo
                    $uploadedFile = $compData['data']['file'];
                    $path = $uploadedFile->store('files', 'public');

                    // Prepara os dados do arquivo
                    $compData['data']['url'] = $path;
                    $compData['data']['name'] = $compData['data']['name'] ?: $uploadedFile->getClientOriginalName();
                    $compData['data']['original_name'] = $uploadedFile->getClientOriginalName();
                    $compData['data']['mime_type'] = $uploadedFile->getMimeType();
                    $compData['data']['file_size'] = $uploadedFile->getSize();
                } elseif ($component) {
                    // Se não houver novo upload, mantém os dados antigos
                    $existingFile = $component->componentable;
                    $compData['data']['url'] = $existingFile->url;
                    $compData['data']['name'] = $compData['data']['name'] ?: $existingFile->name;
                    $compData['data']['original_name'] = $existingFile->original_name;
                    $compData['data']['mime_type'] = $existingFile->mime_type;
                    $compData['data']['file_size'] = $existingFile->file_size;
                }

                // Remove o campo 'file' para não tentar salvar no banco
                unset($compData['data']['file']);
            }


            // Se existe, atualiza; se não, cria
            if (isset($compData['id'])) {
                $component = $this->page->components()->find($compData['id']);
                if ($component) {
                    $component->type = $compData['type'];
                    $component->order = $order;
                    $component->save();
                    $component->componentable->update($compData['data']);
                }
            } else {
                // Cria o model polimórfico conforme o tipo
                switch ($compData['type']) {
                    case 'video':
                        $componentable = \App\Models\Video::create($compData['data']);
                        break;
                    case 'textolivre':
                        $componentable = \App\Models\Textolivre::create($compData['data']);
                        break;
                    case 'imagem':
                        $componentable = \App\Models\Imagem::create($compData['data']);
                        break;
                    default:
                        continue 2;
                }
                $component = $this->page->components()->create([
                    'type' => $compData['type'],
                    'order' => $order,
                    'componentable_id' => $componentable->id,
                    'componentable_type' => get_class($componentable),
                    'file' => null
                ]);
            }
        }

        $this->page->refresh();
        $this->success('Atualizado com sucesso!');
    }

    public function render()
    {
        return view('livewire.pages.page-edit-page');
    }
}
