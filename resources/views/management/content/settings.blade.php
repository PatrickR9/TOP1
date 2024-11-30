<x-app-layout>
    <x-slot name="header">
        @if(isset($add_class))
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 header_title {{$add_class}}">
        @else
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 header_title">
        @endif
            <h3>{{$title}}</h3>
        </div>
    </x-slot>
    <x-slot name="main_slot">
        @livewire('management.content-settings')
    </x-slot>
</x-app-layout>
