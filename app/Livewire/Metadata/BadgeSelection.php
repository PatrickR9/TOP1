<?php

namespace App\Livewire\Metadata;

use Livewire\Component;
use App\Models\MediaType;

class BadgeSelection extends Component
{
    public $badges = [];
    public $selectedBadgeId = null;
    public $value;
    public $metaFieldId;

    public function mount()
    {
        $this->badges = MediaType::all()->map(function ($mediaType) {
            return [
                'id' => $mediaType->id,
                'name' => $mediaType->name,
                'selected' => false,
            ];
        })->toArray();

        if (is_array($this->value)) {
            $this->value = $this->value[0];

            if (!is_null($this->value)) {
                $mediaType = MediaType::find($this->value);
                $this->toggleBadge($mediaType->id, true);
            }
        }
    }

    public function toggleBadge($badgeId, $init)
    {
        foreach ($this->badges as &$badge) {
            if ($badge['id'] === $badgeId) {
                $badge['selected'] = !$badge['selected'];
                $this->selectedBadgeId = $badge['selected'] ? $badgeId : null;
                if (!$init) {
                    $this->dispatch('saveUpdatedValue', ['value' => $badge['id'], 'meta_field_id' => $this->metaFieldId]);
                }
                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.metadata.badge-selection');
    }
}