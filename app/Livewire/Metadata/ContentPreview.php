<?php

namespace App\Livewire\Metadata;

use Livewire\Component;

class ContentPreview extends Component
{
    public $maxLength = 150;
    public $value;
    public $metaFieldId;

    public function mount($value, $metaFieldId)
    {
        $this->value = $value;
        $this->metaFieldId = $metaFieldId;
    }

    public function valueUpdated($newValue)
    {
        $this->dispatch('saveUpdatedValue', ['value' => $newValue, 'meta_field_id' => $this->metaFieldId]);
    }
    
    public function render()
    {
        return view('livewire.metadata.content-preview');
    }
}
