<?php

namespace App\Livewire\Metadata;

use App\Models\Topic;
use Livewire\Component;
use App\Models\TopicType;

class TopicSelection extends Component
{
    public $topicTypes;
    public $values;
    public $metaFieldId;

    protected $listeners = ['topicStateUpdated'];

    public function mount($value)
    {
        $this->values = $value;
        
        if (is_array($this->values)) {
            foreach ($this->values as $id) {
                if($id) {
                    $topic = Topic::find($id);
                    $prefix = 'topics';
                    $checkbox = [
                        'checked' => true,
                        'id' => $topic->id,
                        'name' => $topic->name,
                        'component' => 'topic',
                    ];
                
                    $this->dispatch('triggerHandleCategorySelect', [
                        'prefix' => $prefix,
                        'checkbox' => $checkbox,
                    ]);
                }
            }
        }
        
        $this->topicTypes = TopicType::with('topics')->get();
    }

    public function topicStateUpdated($topicId)
    {
        $this->dispatch('saveUpdatedValue', ['value' => $topicId, 'meta_field_id' => $this->metaFieldId, 'action' => 'addOrRemove']);
        return $this->skipRender();
    }
    
    public function render()
    {
        return view('livewire.metadata.topic-selection');
    }
}
