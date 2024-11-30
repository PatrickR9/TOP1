<div class = "media_pool_body">
    @foreach($sources as $source => $sourceCategories)
    <ul class = "media_pool_team">
    @switch($source)
        @case('protected')
        @foreach($sourceCategories as $sourceCategory)
            <li class = "media_pool_team_header">
                @if($editCategoryId === $sourceCategory->id)
                <span class = "media_pool_team_category_edit">
                    <input type = "text" wire:model="editCategoryName">
                    <button class = "management_button management_small_button fa fa-save" type = "button" wire:click= "saveCategoryById()"></button>
                    <button class = "management_button management_small_button fa fa-close" type = "button" wire:click= "cancelCategory()"></button>
                </span>
                @else
                <span>
                    <button type = "button" class = "management_button management_small_button fa fa-plus" wire:click="addCategory({{$sourceCategory->id}})"></button>
                    <span class = "media_pool_team_name">
                    @if(isset($sourceCategory->organisation_name))
                        {{$sourceCategory->organisation_name}}
                    @else
                        {{$sourceCategory->name}}
                    @endif
                    </span>
                </span>
                <span>
                    {{$sourceCategory->countOfFiles}}
                    @if($sourceCategory->countOfFiles < 2)
                    Datei
                    @else
                    Dateien
                    @endif
                    <button type = "button" class = "management_button management_small_button fa fa-image" wire:click="toCategoryFilesById({{$sourceCategory->id}})"></button>
                    <button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click="editCategory({{$sourceCategory->id}})"></button>
                </span>
                @endif
            </li>
            @include('mediapool.level', ['organisationId' => $sourceCategory->organisation_id, 'parentCategoryId' => $sourceCategory->id, 'categories' => $sourceCategory->categories])
        @endforeach
        @break
        @case('public')
        @foreach($sourceCategories as $sourceCategory)
            <li class = "media_pool_team_header">
                @if($editCategoryId === $sourceCategory->id)
                <span class = "media_pool_team_category_edit">
                    <input type = "text" wire:model="editCategoryName">
                    <button class = "management_button management_small_button fa fa-save" type = "button" wire:click= "saveCategoryById()"></button>
                    <button class = "management_button management_small_button fa fa-close" type = "button" wire:click= "cancelCategory()"></button>
                </span>
                @else
                <span>
                    <button type = "button" class = "management_button management_small_button fa fa-plus" wire:click="addCategory({{$sourceCategory->id}})"></button>
                    <span class = "media_pool_team_name">
                        @if(isset($sourceCategory->parent_id))
                            {{$sourceCategory->name}}
                        @else
                            gemeinsame Bilder
                        @endif
                        </span>
                </span>
                <span>
                    <button type = "button" class = "management_button management_small_button fa fa-image" wire:click="toCategoryFilesById({{$sourceCategory->id}})"></button>
                    @if(isset($sourceCategory->parent_id))
                        <button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click="editCategory({{$sourceCategory->id}})"></button>
                    @endif
                </span>
                @endif
            </li>
            @include('mediapool.level', ['organisationId' => null, 'parentCategoryId' => $sourceCategory->id, 'categories' => $sourceCategory->categories])
        @endforeach
        @break
    @endswitch
    </ul>
    @endforeach
</div>
<div class = "media_pool_footer">
    CATS
</div>