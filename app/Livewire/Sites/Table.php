<?php

namespace App\Livewire\Sites;

use App\Models\Subdomain;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Table extends Component
{
    use Toast;

    #[Computed()]
    public function data(): Collection
    {
        return Subdomain::all();
    }

    public function render()
    {
        return view('livewire.sites.table');
    }

    public function delete($id)
    {
        Subdomain::findOrFail($id)->delete();

        $this->success("Dominio excluido com sucesso!");
    }


    #[On('reload-table-subdomain')]
    public function reloadTableSubdomain(): void
    {
        $this->refresh();
    }
}
