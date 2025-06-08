
@section('title'){{ $subdomain->name }}@endsection

@section('head')
{!!  seo()->for($subdomain) !!}
@endsection


<div>
    <div class="max-w-[800px] mx-auto h-screen">

        <h1 class="text-3xl font-bold dark:text-white text-center pt-10 pb-5"> {{$subdomain->name}} </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 p-5 md:p-0">


            @foreach($this->subdomain->pages as $page)

            <div class="text-2xl text-center text-white bg-opacity-50
                        bg-black pb-3 rounded-lg overflow-hidden shadow-lg hover:shadow-cyan-500/50
                        transition duration-300
                        min-h-48
                        flex items-center">

                <a class="cursor-pointer  transition duration-500 block hover:underline
                        flex flex-col justify-between
                    " href="{{ $page->slug }}">

                    @if($page->image_icon)
                    <img src="{{ Storage::url($page->image_icon) }}" alt="Page Icon"
                        class="w-100 h-32 object-cover mx-auto" />
                    @endif
                    <span class="p-2">
                    {{ $page['title'] }}
                    </span>
                </a>

            </div>

            @endforeach
        </div>

    </div>

</div>
