<?php

namespace App\Livewire\Sites;

use App\Models\Subdomain;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateSubdomain extends Component
{

    use Toast;

    public $show = false;

    #[Validate('string|max:200|required', as: 'nome')]
    public string $name;

    #[Validate('string|max:200|required|unique:subdomains', as: 'URL')]
    public string $domain;

    #[Validate('string|max:200|required', as:'descrição')]
    public string $description;

    public function render()
    {
        return view('livewire.sites.create-subdomain');
    }

    #[On('create-subdomain::show')]
    public function handleshow()
    {
        $this->show = true;
    }

    public function save()
    {
        $this->validate();

        Subdomain::create([
            'name' => $this->name,
            'domain' => $this->domain,
            'description'=> $this->description
        ]);

        $this->success("Dominio criado com sucesso!");

        $this->reset(['name', 'domain', 'show','description']);

        $this->emit('reload-table-subdomain');

    }
}
