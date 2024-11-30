<?php

namespace App\Livewire;

use Livewire\Component;

class CoverLetters extends Component
{
    public $listeners = 
    [
        'startWait' => 'startWait',
        'stopWait' => 'stopWait'
    ];
    public $addWaitClass = '';

    public function startWait()
    {
        $this->addWaitClass = '';
    }
    public function stopWait()
    {
        $this->addWaitClass = 'hidden';
    }
    public function render()
    {
        return view('livewire.cover-letters');
    }
}
