<div>
    <div class="max-w-[800px] mx-auto h-screen">

        <h1 class="text-3xl font-bold text-white text-center pt-10 pb-5"> {{$subdomain->name}} </h1>

        @foreach($this->subdomain->pages as $page)

        <div class="m-5 text-2xl text-center py-5 text-white bg-opacity-50 bg-black">

            <a class="cursor-pointer  hover:underline" href="{{ $page->slug }}">
                {{ $page['title'] }}
            </a>

        </div>

        @endforeach

    </div>

</div>
