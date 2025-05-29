<?php

namespace App\Livewire\Sites;

use App\Models\Subdomain;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Table extends Component
{

    #[Computed()]
    public function data(): Collection
    {
        return Subdomain::all();
    }

    public function render()
    {
        return view('livewire.sites.table');
    }
}
