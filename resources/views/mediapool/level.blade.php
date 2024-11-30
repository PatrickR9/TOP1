@if(isset($editCategoryParentId) && ($editCategoryParentId === $parentCategoryId))
<ul class = "">
    <li>
        neu <input type = "text" wire:model="editCategoryName">
        <button class = "management_button management_small_button fa fa-save" type = "button" wire:click= "saveCategory()"></button>
        <button class = "management_button management_small_button fa fa-close" type = "button" wire:click= "cancelCategory()"></button>
    </li>
</ul>
@endif
@if(count($categories) > 0)
<ul class = "media_pool_team_category">
    @foreach($categories as $category)
        <li class = "media_pool_team_category_row">
            @if($editCategoryId === $category->id)
            <span class = "media_pool_team_category_edit">
                <input type = "text" wire:model="editCategoryName">
                <button class = "management_button management_small_button fa fa-save" type = "button" wire:click= "saveCategoryById()"></button>
                <button class = "management_button management_small_button fa fa-close" type = "button" wire:click= "cancelCategory()"></button>
            </span>
            @else
            <button type = "button" class = "management_button management_small_button fa fa-plus" wire:click="addCategory({{$category->id}})"></button>
            <span class = "media_pool_team_category_name">
                @if($category->name === '')
                <span>keine Kategorie</span>
                @else
                <span>{{$category->name}}</span>
                @endif
                <span>
                    {{$category->countOfFiles}}
                    @if($category->countOfFiles < 2)
                    Datei
                    @else
                    Dateien
                    @endif
                    <button type = "button" class = "management_button management_small_button fa fa-image" wire:click="toCategoryFilesByCategory({{$category->id}})"></button>
                    <button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click="editCategory({{$category->id}})"></button>
                </span>
            </span>
            @endif
        </li>
        @include('mediapool.level', ['organisationId' => $organisationId, 'parentCategoryId' => $category->id, 'categories' => $category->categories])
    @endforeach
</ul>
@endif