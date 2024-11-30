<div class = "media_pool" id = "media_pool">
    <div class = "media_pool_head">
        MEDIA POPUP
    </div>
    <div class = "media_pool_body">
    @foreach($mediaPool['files'] as $mediaFile)
        <div class = "media_pool_row">
            <img class = "management_img_small_preview" src = "{{route('image.show', ['imageName' => $mediaFile, 'assign' => $mediaPool['assign'], 'id' => $mediaPool['id']])}}" wire:click="setMedia('{{$mediaPool['target']}}','{{$mediaFile}}')">
            <span>{{$mediaFile}}</span>
        </div>
    @endforeach
    </div>
</div>