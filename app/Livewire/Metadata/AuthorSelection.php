<?php

namespace App\Livewire\Metadata;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuthorSelection extends Component
{
    public $placeholderText;
    public $search = '';
    public $items = [];
    public $noResults = false;
    public $showDropdown = false;
    public $selectedItems = [];


    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->selectedItems[] = $user;
        }
        $this->placeholderText = 'Urheber wählen';
        $this->updateItemList();
    }

    public function updatedSearch()
    {
        $this->updateItemList();
    }

    public function selectItem($itemId)
    {
        $item = User::find($itemId);
        if ($item && !in_array($item, $this->selectedItems)) {
            $this->selectedItems[] = $item;
        }
    }

    public function removeItem($id)
    {
        $this->selectedItems = array_filter($this->selectedItems, function ($item) use ($id) {
            return $item->id !== $id;
        });
    }

    private function updateItemList()
    {
        $query = User::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $query->orderBy('name', 'asc');

        $this->items = $query->get();

        $this->noResults = $this->items->isEmpty() && !empty($this->search);
    }

    public function render()
    {
        return view('livewire.metadata.author-selection');
    }
}
