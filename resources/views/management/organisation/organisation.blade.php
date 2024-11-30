<div>
    <form action = "" wire:submit="update({{$id}})">
        <div class = "management_edit_table">
            <div class = "management_edit_table_header">
                <div class = "management_edit_table_row right">
                    <button class = "management_button" type = "button" wire:click="reload()">{{__('cancel')}}</button>
                    <button class = "management_button" type = "submit">{{__('save')}}</button>
                </div>
            </div>
            <div class = "management_edit_table_body">
            @foreach($organisationFields as $cField => $cValue)
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">{{$cField}}</div>
                    <div class = "management_edit_row_input">
                    @switch($cField)
                        @case('title')
                        @case('short_title')
                        @case('street')
                        @case('city')
                        @case('website')
                            <input class = "input_long" type = "text" wire:model="{{$cField}}">
                        @break;
                        @case('email')
                            <input class = "input_long" type = "email" wire:model="{{$cField}}">
                        @break;
                        @case('zip')
                        @case('country')
                            <input class = "input_small" type = "text" wire:model="{{$cField}}">
                        @break;
                        @case('active')
                            @if($cValue === 1)
                                <input type = "checkbox" checked wire:model="{{$cField}}">
                            @else
                                <input type = "checkbox" wire:model="{{$cField}}">
                            @endif
                        @break;
                        @case('logo')
                        @case('logo_for_light_bg')
                        @case('logo_for_dark_bg')
                            <button type = "button" class = "management_button management_small_button fa fa-image" wire:click="mediaPool('{{$cField}}', ['image/jpeg', 'image/png', 'application/svg+xml'])"></button>
                            <input type = "hidden" wire:model="{{$cField}}">
                            @if(isset($cValue) && ($cValue !== ''))
                            <div class = "management_edit_row_image">
                                <img class = "management_img_small_preview" src = "{{route('image.show', ['imageName' => $cValue, 'source' => 'organisations', 'id' => $id])}}">
                                <button type = "button" class = "management_button management_small_button warning fa fa-close" wire:click="removeImage('{{$cField}}')"></button>
                            </div>
                            <span>{{$cValue}}</span>
                            @endif
                        @break;
                        @default
                        {{$cValue}}
                        @break;
                    @endswitch
                    </div>
                </div>
            @endforeach
            </div>
            <div class = "management_edit_table_footer">
                <div class = "management_edit_table_row right">
                    <button class = "management_button" type = "button" wire:click="reload">{{__('cancel')}}</button>
                    <button class = "management_button" type = "submit">{{__('save')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>