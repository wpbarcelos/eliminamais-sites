<?php

namespace App\Livewire;

use App\Models\Subdomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.auth')]
class AcessoPage extends Component
{

    use Toast;

    public string $codigo;

    public $subdomain;

    public function mount(Request $request): void
    {
        $mainUrl = env('MAIN_URL', 'app.test');
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $this->subdomain = Subdomain::where('domain', "$subdomain.$mainUrl")->first();
    }

    public function login(): void
    {
        //dd($this->codigo, $this->subdomain?->toArray());

        if (strtoupper($this->subdomain->codigo) == strtoupper($this->codigo)) {
            Session::put('codigo_acesso', $this->codigo);

            redirect(url('/'));
        } else {
            $this->error("CODIGO inválida");
        };
    }

    public function render()
    {
        return view('livewire.acesso-page');
    }
}
