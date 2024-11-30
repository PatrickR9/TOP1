<x-app-layout>
    <x-slot name="header">
        @if(isset($add_class))
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 header_title {{$add_class}}">
        @else
        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 header_title">
        @endif
            <h1>*{{$title}}</h1>
        </div>
    </x-slot>
    <x-slot name="main_slot">
        @livewire('d_editor.sites')
    </x-slot>
</x-app-layout>