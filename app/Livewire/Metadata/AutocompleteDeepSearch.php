<?php

namespace App\Livewire\Metadata;

use Livewire\Component;
use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Support\Facades\DB;

class AutocompleteDeepSearch extends Component
{
    public $value;
    public $metaFieldId;
    public $placeholderText;
    public $originalPlaceholderText;
    public $search = '';
    public $items = [];
    public $selectedMainItems;
    public $subItems = [];
    public $noResults = false;
    public $showDropdown = false;
    public $showSearchInput = true;
    public $iconType = '';
    public $selectedItem = '';


    public function mount()
    {
        if (is_array($this->value)) {
            $this->value = $this->value[0];
        }

        $this->selectedMainItems = collect();
        $this->originalPlaceholderText = 'Materialarten durchsuchen';
        $this->placeholderText = $this->originalPlaceholderText;

        $material = Material::find($this->value);
        if ($material) {
            $materialType = MaterialType::find($material->material_type_id);
            $this->fetchMaterialTypeParents($materialType);
            $this->selectedItem = $material;
            $this->showSearchInput = false;
        }
        $this->updateItemList();
    }

    private function fetchMaterialTypeParents($materialType)
    {
        $this->selectedMainItems->prepend($materialType);

        if ($materialType->parent_id !== null) {
            $parentMaterialType = MaterialType::find($materialType->parent_id);
            
            if ($parentMaterialType) {
                $this->fetchMaterialTypeParents($parentMaterialType);
            }
        }
    }

    public function handleFocus()
    {
        $this->showDropdown = true;
        $this->updateItemList();
    }

    public function updatedSearch()
    {
        $this->updateItemList();
    }

    public function selectItem($uniqueId)
    {
        [$prefix, $itemId] = explode('-', $uniqueId);

        if ($prefix === 'material') {
            $item = Material::find($itemId);
            if ($item) {
                $this->selectedItem = $item;
                $this->dispatch('saveUpdatedValue', ['value' => $item->id, 'meta_field_id' => $this->metaFieldId]);
                $this->showSearchInput = false;
            }
        } elseif ($prefix === 'materialType') {
            $item = Materialtype::find($itemId);
            if ($item) {
                $this->subItems = MaterialType::select('name', DB::raw("CONCAT('materialType-', id) as unique_id"))
                    ->where('parent_id', $item->id)
                    ->union(
                        Material::select('name', DB::raw("CONCAT('material-', id) as unique_id"))
                            ->where('material_type_id', $item->id)
                    )
                    ->orderBy('name', 'asc')
                    ->get();
                $this->placeholderText = $item->name;
                $this->selectedMainItems->push($item);
                $this->search = '';
                $this->iconType = 'deep_search';
                $this->updateItemList();
            }
        }
    }

    public function navigateTo($item = null)
    {
        if($item) {
            $itemToSearch = $item['id'];
            $index = $this->selectedMainItems->search(function($element) use ($itemToSearch) {
                return $element['id'] === $itemToSearch;
            });
            $index += 1;

            $this->selectedMainItems = $this->selectedMainItems->slice(0, $index)->values();

            $this->subItems = MaterialType::select('name', DB::raw("CONCAT('materialType-', id) as unique_id"))
                ->where('parent_id', $this->selectedMainItems->last()->id)
                ->union(
                    Material::select('name', DB::raw("CONCAT('material-', id) as unique_id"))
                        ->where('material_type_id', $this->selectedMainItems->last()->id)
                )
                ->orderBy('name', 'asc')
                ->get();
            $this->placeholderText = $this->selectedMainItems->last()->name;
            $this->search = '';
            $this->showSearchInput = true;
            $this->selectedItem = '';
            $this->dispatch('saveUpdatedValue', ['value' => null, 'meta_field_id' => $this->metaFieldId]);
        }
        else {
            $this->selectedMainItems = collect();
            $this->removeItem();
        }
    }

    public function upOneLayer()
    {
        if ($this->iconType === 'deep_search') {
            $this->selectedMainItems->pop();
            if ($this->selectedMainItems->isEmpty()) {
                $this->removeItem();
            } else {
                $this->subItems = MaterialType::select('name', DB::raw("CONCAT('materialType-', id) as unique_id"))
                    ->where('parent_id', $this->selectedMainItems->last()->id)
                    ->union(
                        Material::select('name', DB::raw("CONCAT('material-', id) as unique_id"))
                            ->where('material_type_id', $this->selectedMainItems->last()->id)
                    )
                    ->orderBy('name', 'asc')
                    ->get();
                $this->placeholderText = $this->selectedMainItems->last()->name;
                $this->search = '';
                $this->updateItemList();
            }
        }
    }

    public function removeItem()
    {
        $this->search = '';
        $this->selectedItem = '';
        $this->dispatch('saveUpdatedValue', ['value' => null, 'meta_field_id' => $this->metaFieldId]);
        $this->subItems = null;
        $this->placeholderText = $this->originalPlaceholderText;
        $this->showSearchInput = true;
        $this->iconType = '';
        $this->selectedMainItems->splice(0, $this->selectedMainItems->count());
        $this->updateItemList();
    }

    private function updateItemList()
    {
        if (!$this->subItems) {
            $queryMaterialTypes = MaterialType::select('name', DB::raw("CONCAT('materialType-', id) as unique_id"))
                ->where('parent_id', null);

            if ($this->search) {
                $queryMaterialTypes->where('name', 'like', '%' . $this->search . '%');
            }

            $queryMaterials = Material::select('name', DB::raw("CONCAT('material-', id) as unique_id"))
                ->where('material_type_id', null);

            if ($this->search) {
                $queryMaterials->where('name', 'like', '%' . $this->search . '%');
            }

            $this->items = $queryMaterialTypes
                ->union($queryMaterials)
                ->orderBy('name', 'asc')
                ->get();

            $this->noResults = $this->items->isEmpty() && !empty($this->search);
        } else {
            $queryMaterialTypes = MaterialType::select('name', DB::raw("CONCAT('materialType-', id) as unique_id"))
                ->where('parent_id', $this->selectedMainItems->last()->id);

            if ($this->search) {
                $queryMaterialTypes->where('name', 'like', '%' . $this->search . '%');
            }

            $queryMaterials = Material::select('name', DB::raw("CONCAT('material-', id) as unique_id"))
                ->where('material_type_id', $this->selectedMainItems->last()->id);

            if ($this->search) {
                $queryMaterials->where('name', 'like', '%' . $this->search . '%');
            }

            $this->items = $queryMaterialTypes
                ->union($queryMaterials)
                ->orderBy('name', 'asc')
                ->get();


            $this->noResults = $this->items->isEmpty() && !empty($this->search);
        }
    }

    public function render()
    {
        return view('livewire.metadata.autocomplete-deep-search');
    }
}