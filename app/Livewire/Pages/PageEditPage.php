<?php

namespace App\Livewire\Pages;

use App\Models\Page;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class PageEditPage extends Component
{

    use Toast;

    public ?Page $page;

    #[Validate('required|string|max:255')]
    public string $title;

    #[Validate('required|string|min:3|max:255')]
    public string $slug;

    public $components;



    public function mount(Page $page)
    {
        $this->page  = $page;

        $this->page->load('components');

        $this->title = $page->title;
        $this->slug = $page->slug;

        $this->components = $page->components->map(function ($component) {
            return [
                'id' => $component->id,
                'type' => $component->type,
                'data' => $component->componentable->toArray(),
            ];
        })->toArray();
    }


    public function addComponent()
    {
        $this->components[] = [
            'type' => 'textolivre', // valor padrão, pode ser 'video' ou 'imagem'
            'data' => [
                'url' => '',
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

        $this->page->update([
            'title' => $this->title,
            'slug' => $this->slug,
            // 'content' => $this->content,
        ]);



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
