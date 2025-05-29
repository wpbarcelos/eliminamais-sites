<?php

namespace App\Livewire\Sites;

use App\Models\Page;
use App\Models\Subdomain;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class EditPage extends Component
{
    use Toast;

    public Subdomain $subdomain;

    #[Validate('required|string|min:2|max:100')]
    public $name;
    #[Validate('required|min:2|max:100')]
    public $domain;

    #[Validate("string")]
    public $codigo;

    public function mount(Subdomain $subdomain)
    {
        $this->subdomain = $subdomain;

        $this->name = $subdomain->name;

        $this->domain = $subdomain->domain;

        $this->codigo = $subdomain->codigo;
    }


    #[On('page-created')]
    public function onPageCreated()
    {
        $this->subdomain->refresh();
    }

    public function save()
    {
        $this->subdomain->update([
            'name' => $this->name,
            'domain' => $this->domain,
            'codigo' => $this->codigo
        ]);

        $this->success('Atualizado com sucesso!');
    }

    public function deletePage($pageId)
    {
        Page::findOrFail($pageId)->delete();
    }

    public function render()
    {
        return view('livewire.sites.edit-page');
    }
}
