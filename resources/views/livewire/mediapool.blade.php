<div>
    @if(isset($pool))
    <div class = "media_pool" id = "media_pool">
        <div class = "media_pool_header">
            <div class = "header_logo_box">
                @if(false)
                <img class = "" src = "{{route('image.show', ['imageName' => 'logo-white.png'])}}">
                @endif
            </div>
            <div class = "media_pool_head_title">
                <h3>MEDIA POOL - {{$currentView}}</h3>
                @if($poolView === 'categories')
                <button type = "button" class = "management_button" wire:click="setView('files')"><span class = "fa fa-arrow-circle-left"></span> zu den Dateien</button>
                @else
                @if($pool['source'] === 'public')
                {{$categoryName}}
                @else
                Verband - {{$organisationName}}
                @endif
                <button type = "button" class = "management_button" wire:click="setView('categories')"><span class = "fa fa-arrow-circle-left"></span> zu den Kategorien</button>
                @endif
            </div>
            <button class = "management_button management_small_button fa fa-close" wire:click="closePool()"></button>
        </div>
        @if($poolView === 'categories')
        @include('mediapool.categories', ['sources' => $sources])
        @else
        @include('mediapool.files', ['pool' => $pool])
        @endif
    </div>
    @endif
</div>