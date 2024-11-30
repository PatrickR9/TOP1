<?php

namespace App\Livewire\Metadata;

use App\Models\User;
use Livewire\Component;
use App\Models\Organisation;

class AutocompleteSearch extends Component
{
    public $authorId;
    public $model;
    public $column;
    public $placeholderText;
    public $search = '';
    public $items = [];
    public $noResults = false;
    public $showDropdown = false;
    public $selectedItem = '';


    public function mount($authorId, $model, $column, $placeholderText)
    {
        $this->authorId = $authorId;
        $this->model = $model;
        $this->column = $column;
        $this->placeholderText = $placeholderText;
        $this->updateItemList();
    }

    public function updatedSearch()
    {
        $this->updateItemList();
    }

    public function selectItem($itemId)
    {
        $modelClass = "App\\Models\\" . $this->model;
        $item = $modelClass::find($itemId);
        $this->selectedItem = $item;
    }

    public function removeItem()
    {
        $this->selectedItem = '';
    }

    private function updateItemList()
    {
        $modelClass = "App\\Models\\" . $this->model;

        if ($modelClass === 'App\Models\Organisation') {
            $query = Organisation::query()
            ->join('editorials', 'editorials.organisation_id', '=', 'organisations.id')
            ->join('editorial_members', 'editorials.id', '=', 'editorial_members.editorial_id')
            ->where('editorial_members.user_id', $this->authorId)
            ->whereNull('organisations.deleted_at')
            ->whereNull('editorials.deleted_at')
            ->select('organisations.*')
            ->distinct();
        } elseif ($modelClass === 'App\Models\Editorial') {
            $user = User::find($this->authorId);
            $query = $user->editorials();
        } else {
            $query = $modelClass::query();
        }

        if ($this->search) {
            if ($modelClass === 'App\Models\Organisation') {
                $query->where('organisations.title', 'like', '%' . $this->search . '%');
            }
            else {
                $query->where($this->column, 'like', '%' . $this->search . '%');
            }
        }

        if ($modelClass === 'App\Models\Organisation') {
            $query->orderBy('organisations.title', 'asc');
        } else {
            $query->orderBy($this->column, 'asc');
        }

        $this->items = $query->get();

        if (count($this->items) === 1) {
            $this->selectedItem = $this->items[0];
        }

        $this->noResults = $this->items->isEmpty() && !empty($this->search);
    }

    public function render()
    {
        return view('livewire.metadata.autocomplete-search');
    }
}
