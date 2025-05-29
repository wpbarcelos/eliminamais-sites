<?php

namespace App\Livewire\Site;

use App\Models\Subdomain;
use Livewire\Component;

class HomePage extends Component
{

    public Subdomain $subdomain;

    public function mount(): void
    {
        $subdomain_id = request()->get('subdomain_id');

        $this->subdomain = Subdomain::query()
            ->when($subdomain_id, function ($query) use ($subdomain_id) {
                $query->where('id', $subdomain_id);
            })
            ->when(empty($subdomain_id), function ($query) {})
            ->with(['pages'])
            ->first();
    }

    public function render()
    {
        return view('livewire.site.home')
            ->layout('components.layouts.site');
    }
}
