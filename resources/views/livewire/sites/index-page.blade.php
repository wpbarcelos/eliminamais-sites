<div>

    <x-header title="Sites" separator/>

    @livewire('sites.table')

    <x-button wire:click="$dispatch('create-subdomain::show')" label="Novo site" class="mt-5"/>

    <livewire:sites.create-subdomain />

</div>
