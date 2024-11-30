<x-app-layout>
    <x-slot name="main_slot">
        <div class = "d_site">
        @include('d_editor.stepindicator')
        @livewire('managementtopblock', ['step' => $step, 'siteId' => $siteId, 'contentId' => $contentId])
        @switch($step)
            @case(1)
                @livewire('management.content-edit', ['step' => $step, 'siteId' => $siteId, 'siteType' => $siteType, 'contentId' => $contentId])
            @break
            @case(2)
            <form id = "d_property_component_form" onsubmit = "return false;">
                {!! csrf_field() !!}
                <input type = "hidden" name = "id" value = "{{$siteId}}">
                <input type = "hidden" name = "content_id" value = "{{$contentId}}">
                <input type = "hidden" name = "type" value = "{{$siteType}}">
            </form>
                @livewire('d-editor.d-editor', ['step' => $step, 'siteId' => $siteId, 'siteType' => $siteType, 'contentId' => $contentId])
                @include('d_editor.properties')
            @break
            @case(3)
                @livewire('d-editor.content-materials', ['step' => $step, 'siteId' => $siteId, 'siteType' => $siteType, 'contentId' => $contentId])
            @break
            @case(4)
            <form id="d_property_component_form" onsubmit="return false;">
                {!! csrf_field() !!}
                <input type="hidden" name="content_id" value="{{$contentId}}">
            </form>
                @livewire('d-editor.content-properties', ['step' => $step, 'siteId' => $siteId, 'siteType' => $siteType, 'contentId' => $contentId])
            @break
            @case(5)
                @include('d_editor.contributioncheck')
            @break
        @endswitch
        </div>
        @if(isset($coverLetters))
            @livewire('cover-letters')
            <div id = "d_editor_wait">
                <div id = "d_editor_wait_letters">
                @foreach($coverLetters as $coverLetter)
                <span class = "d_editor_wait_letter">{!!$coverLetter!!}</span>
                @endforeach
            </div>
        </div>            
        @endif
    </x-slot>
</x-app-layout>
