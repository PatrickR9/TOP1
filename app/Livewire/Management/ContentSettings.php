<?php

namespace App\Livewire\Management;

use Livewire\Component;

class ContentSettings extends Component
{
    public $sections = [];
    public string $textareaContent = '';
    public int $charCount = 0;

    public function updatedTextareaContent()
    {
        $this->charCount = mb_strlen($this->textareaContent);
    }

    public function mount()
    {
        $this->sections = [
            [
                'label' => 'Ausspielwege',
                'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00a3e0"><path d="M400-400h160v-80H400v80Zm0-120h320v-80H400v80Zm0-120h320v-80H400v80Zm-80 400q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"></path></svg>',
                'rightText' => 'online',
                'content' => [
                    [
                        'description' => null,
                        'label' => 'Plattform und Layout',
                        'type' => 'platform',
                    ],
                    [
                        'description' => null,
                        'label' => 'Veröffentlichung',
                        'type' => 'publication',
                    ],
                ],
            ],
            [
                'label' => 'Wiedervorlage',
                'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00a3e0"><path d="M400-400h160v-80H400v80Zm0-120h320v-80H400v80Zm0-120h320v-80H400v80Zm-80 400q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"></path></svg>',
                'rightText' => null,
                'content' => [
                    [
                        'description' => 'Wähle ein Datum, wann der Beitrag wieder als To Do angezeigt werden soll. Z.B. wenn absehbar ist, dass der Beitrag ein Jahr später (z.B. aus rechtlichen Gründen) nochmal überarbeitet werden muss. Wenn das gewählte Datum erreicht ist, wird sowohl der Autor als auch der Redakteur benachrichtigt, dass dieser Beitrag angeschaut werden muss.',
                        'label' => 'Datum zur Wiedervorlage',
                        'type' => 'date',
                    ],
                    [
                        'description' => 'Grund der Wiedervorlage',
                        'label' => null,
                        'type' => 'longtext',
                    ],
                    [
                        'description' => null,
                        'label' => null,
                        'type' => 'toogle_switch',
                    ],
                ],
            ],
            [
                'label' => 'Urheberrecht und Copyright',
                'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00a3e0"><path d="M400-400h160v-80H400v80Zm0-120h320v-80H400v80Zm0-120h320v-80H400v80Zm-80 400q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"></path></svg>',
                'rightText' => null,
                'content' => [
                    [
                        'description' => 'Bitte wähle hier die Autoren/Urheber des Beitrags aus.',
                        'label' => 'Urheber',
                        'type' => 'author',
                    ],
                    [
                        'description' => 'Bitte füge hier alle externen Copyrights des Beitrags ein. Jeder Zeile wird automatisch in der Veröffentlichung "©" vorangestellt. Wenn hier nichts eingetragen wird, wird der gewählte Verband des Copyright-Inhaber angezeigt. Bsp.: "Max Mustermann (Text und Melodie)"',
                        'label' => 'Externe Rechte ©',
                        'type' => 'text',
                        'placeholder' => 'Externe Rechte hier eintragen',
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.management.content-settings');
    }
}
