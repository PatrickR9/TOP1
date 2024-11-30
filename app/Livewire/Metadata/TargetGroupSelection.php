<?php

namespace App\Livewire\Metadata;

use Livewire\Component;
use App\Models\TargetGroup;
use App\Models\TargetGroupType;

class TargetGroupSelection extends Component
{
    public $targetGroupTypes;
    public $values;
    public $metaFieldId;

    protected $listeners = ['targetGroupStateUpdated'];
    
    public function mount($value)
    {
        $this->values = $value;

        if (is_array($this->values)) {
            foreach ($this->values as $id) {
                if ($id) {
                    $targetGroup = TargetGroup::find($id);
                    $prefix = 'targetGroups';
                    $checkbox = [
                        'checked' => true,
                        'id' => $targetGroup->id,
                        'name' => $targetGroup->name,
                        'component' => 'targetGroup',
                    ];
                
                    $this->dispatch('triggerHandleCategorySelect', [
                        'prefix' => $prefix,
                        'checkbox' => $checkbox,
                    ]);
                }
            }
        }

        $this->targetGroupTypes = TargetGroupType::with('targetGroups')->get();
    }

    public function targetGroupStateUpdated($targetGroupId)
    {
        $this->dispatch('saveUpdatedValue', ['value' => $targetGroupId, 'meta_field_id' => $this->metaFieldId, 'action' => 'addOrRemove']);
        return $this->skipRender();
    }

    public function render()
    {
        return view('livewire.metadata.target-group-selection');
    }
}
