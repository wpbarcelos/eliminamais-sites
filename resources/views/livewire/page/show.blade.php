<?php

use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\{Layout, Title};

new
#[Layout('components.layouts.site')]
class extends Component {
    use Toast;

    public Page $page;

    public function mount(Page $page):void
    {
      $this->page = $page;
      $this->page->load('components','subdomain');


    }

    public function with(): array
    {
        return [
        ];
    }
}; ?>

@section('title'){{ $page->subdomain->name }}@endsection

@section('head')
{!!  seo()->for($page) !!}
@endsection

<div>

    <div class="max-w-[800px] mx-auto ">

        @if($page->image)
            <img src="{{ Storage::url($page->image) }}" alt="Page Image" class="w-full h-auto" />
        @endif

        <h1 class="text-4xl dark:text-white text-center font-semibold py-12">
            {{  $page->title }}
        </h1>

        <a href="{{ url()->previous() == url()->current() ? '/' : url()->previous()}}"
            class="btn w-full rounded p-7 bg-black text-lg text-white font-semibold my-5
                hover:underline
            ">
            Voltar
        </a>

        @foreach($this->page->components as $component)

            <div class="mt-5 mb-10">

                @php
                  $data = $component->componentable;
                @endphp

                @if($data instanceof App\Models\Imagem)

                    <x-site.imagem :$data/>

                @elseif($data instanceof App\Models\TextoLivre)

                    <x-site.textolivre :$data/>

                @elseif($data instanceof App\Models\Video)

                    <x-site.video :$data />

                @elseif($data instanceof App\Models\File)
                    
                    <x-site.file :$data />
                    
                @endif

            </div>

        @endforeach

    </div>
</div>
