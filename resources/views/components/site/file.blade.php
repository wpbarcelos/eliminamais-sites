@props(['data'])


<div class="mx-2 flex items-center justify-center ">

    <a class="text-lg  text-blue-500 underline font-bold " href="{{ Storage::url($data->url) }}" title="{{$data->description}}">{{$data->name}}</a>
</div>    