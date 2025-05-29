<?php

namespace App\Livewire\Pages;

use App\Models\Page;
use App\Models\Subdomain;
use Illuminate\Support\Stringable;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class ModalCreatePage extends Component
{
    use Toast;


    public Subdomain $subdomain;

    public bool $modal = false;

    #[Validate('required|string|min:2|max:100')]
    public $title;

    #[Validate('required|min:2|max:100')]
    public $slug;

    #[On('create-page::show')]
    public function showModal()
    {
        $this->modal = true;
    }

    public function save()
    {
        $this->validate();

        Page::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'subdomain_id' => $this->subdomain->id
        ]);

        $this->modal = false;

        $this->success("Pagina criada com sucesso!");

        $this->dispatch('page-created');
    }

    public function render()
    {
        return view('livewire.pages.modal-create-page');
    }
}
