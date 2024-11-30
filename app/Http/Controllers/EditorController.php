<?php

namespace App\Http\Controllers;

//use App\Models\Siteblock;
use App\Models\User;
use App\Models\Usersite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EditorController extends Controller
{
    private static $classValues =
    [
        'width' =>
        [
            'label' => 'Breite',
            'options' =>
            [
                'w100' => 'volle Breite',
                'w2_3' => 'Zweidrittel der Breite',
                'w50' => 'Halbe Breite',
                'w1_3' => 'Dritel der Breite'
            ]
        ],
        'border' =>
        [
            'label' => 'Rahmen',
            'options' =>
            [
                'none' => 'keine',
                'outside' => 'außen'
            ]
        ]
    ];
    private $dataFigure =
    [
        'data-image-caption' => 'checked',
        'data-image-caption-text' => 'Bildbeschriftung'
    ];
    private $dataTable = 
    [
        'data-table-col' => 3,
        'data-table-row' => 1,
        'data-table-caption' => 'checked',
        'data-table-caption-text' => 'Tabellenüberschrift ',
        'data-table-col-head' => 'checked',
        'data-table-row-head' => 'checked',
    ];
    private $userSite;

    function dComponentInsert(Request $req)
    {
        $returnHtml = '';
        if($req->has('dBlockId'))
        {
            $dBlockId = $req->get('dBlockId');
            $siteId = $req->get('id');
            $returnHtml = '';
            $newContent = '';
            $addButton = '';
            $addBorderLi = '';
            # Uniqe ID from user id and timestamp
            $timeStamp = Auth::user()->id.'_'.$req->get('dTimeStamp');
            $newBlockId = 'd_editor_block_'.$timeStamp;
            $editorContentId = 'd_editor_content_'.$timeStamp;
            switch($dBlockId)
            {
                case 'dc_bibleapi_new':
                {
                    $returnHtml = '
                    <div id = "'.$editorContentId.'" class = "d_editor_box" data-class-width = "w100" data-content-type = "bible">Hauptbibelstelle</div>';
                    $bibleApiValues = $editorContentId.'_bible_values';
//                    $siteBlock = new \stdClass();
                    $viewParams = 
                    [
                        'siteBlock' => new \stdClass()
                    ];
                    $viewParams['siteBlock']->editor_id = $editorContentId;
                    $viewParams['siteBlock']->editor_attribs['data-bible-values'] = '*';
                    $addButton = view('d_editor.managementattrib-bible', $viewParams)->render();                    
                    break;
                }
                case 'dc_hx_new':
                {
                    $newContent = 'Titel';
                    $returnHtml = '
                    <h1 id = "'.$editorContentId.'" class = "d_editor_box" onmouseenter = "tmceInit(this)" data-class-width = "w100" data-content-type = "text">'.$newContent.'</h1>';
                    break;
                }
                case 'dc_media_new':
                {
                    $figImageId = str_replace('_content_', '_figure_image_', $editorContentId);
                    $newFigure = self::drawFigure(array_merge($this->dataFigure, ['editor_content_id' => $editorContentId]));
                    $newContent = $newFigure->content;
                    $figureAttribs = $newFigure->attribs;
                    $returnHtml = '<div id = "'.$editorContentId.'" class = "d_editor_box" data-class-width = "w100" data-content-type = "figure" '.implode(' ', $newFigure->attribs).'>'.$newContent.'</div>';
                    $imageCaptionId = $editorContentId.'_image_caption';
                    $imageCaptionTextId = $editorContentId.'_image_caption_text';
                    $attribValues = ''.$imageCaptionId.'.checked, '.$imageCaptionTextId.'.value]';
                    $attribNames = "['$imageCaptionId', '$imageCaptionTextId']";
//                    $siteBlock = new \stdClass();
                    $viewParams = 
                    [
                        'siteBlock' => new \stdClass()
                    ];
                    $viewParams['siteBlock']->editor_id = $editorContentId;
                    $viewParams['siteBlock']->editor_attribs['data-image-caption'] = 'checked';
                    $viewParams['siteBlock']->editor_attribs['data-image-caption-text'] = 'Bildbeschriftung';
                    $addButton = view('d_editor.managementattrib-figure', $viewParams)->render();
                    break;
                }
                case 'dc_table_new':
                {
                    $newTable = self::drawTable(array_merge($this->dataTable, ['editor_content_id' => $editorContentId]));
                    $newContent = $newTable->content;
                    $tableAttribs = $newTable->attribs;
                    $returnHtml = '
                    <div id = "'.$editorContentId.'" class = "d_editor_box" data-class-width = "w100" data-content-type = "table" '.implode(' ', $tableAttribs).'>'.$newContent.'</div>';
                    $colTableId = $editorContentId.'_table_col';
                    $rowTableId = $editorContentId.'_table_row';
                    $captionTableId = $editorContentId.'_table_caption';
                    $captionTextTableId = $editorContentId.'_table_caption_text';
                    $colHeadTableId = $editorContentId.'_table_col_head';
                    $rowHeadTableId = $editorContentId.'_table_row_head';
                    $attribNames = "['data-table-col', 'data-table-row', 'data-table-caption', 'data-table-caption-text', 'data-table-col-head', 'data-table-row-head']";
                    $attribValues = '['.$colTableId.'.value, '.$rowTableId.'.value, '.$captionTableId.'.checked, '.$captionTextTableId.'.value, '.$colHeadTableId.'.checked, '.$rowHeadTableId.'.checked]';
                    $viewParams = 
                    [
                        'siteBlock' => new \stdClass()
                    ];
                    $viewParams['siteBlock']->editor_id = $editorContentId;
                    $viewParams['siteBlock']->editor_attribs = $this->dataTable;
                    $addButton = view('d_editor.managementattrib-table', $viewParams)->render();
                    $addBorderLi = '<li class="block_property_row" wire:click="setContentAttribs(\''.$editorContentId.'\', \'data-class-border\',\'inside\')">
                                <span class="block_border_inside">
                                    <span class="inside">
                                        <span class = "inside_cell"></span>
                                        <span class = "inside_cell"></span>
                                        <span class = "inside_cell"></span>
                                        <span class = "inside_cell"></span>
                                    </span>
                                </span>
                                <span class="block_width_label">2/3</span>
                            </li>';
                    break;
                }
                case 'dc_text_new':
                {
                    $newContent = '<p>Lorem ipsum dolor sit amet...</p>';
                    $returnHtml = '
                    <div id = "'.$editorContentId.'" class = "d_editor_box" onmouseenter = "tmceInit(this)" data-class-width = "w100" data-content-type = "text">'.$newContent.'</div>';
                    break;
                }
            }
        }
        $propertyBlocks = '';
        foreach(self::$classValues as $property => $propertyValues)
        {
            $propertyOptions = '';
            $dataClassValue = 'data-class-'.$property;
            foreach($propertyValues['options'] as $optionValue => $optionLabel)
            {
                $propertyOptions .= '
                            <li class="block_property_row" wire:click="setContentAttribs(\''.$editorContentId.'\', \''.$dataClassValue.'\',\''.$optionValue.'\')">
                                <span class="block_'.$property.'_shown"><span class="'.$optionValue.'"></span></span>
                                <span class="block_'.$property.'_label">'.$optionLabel.'</span>
                            </li>';
            }
            $propertyBlocks .= '
                        <label>'.$propertyValues['label'].'</label>
                        <ul class="block_property block_'.$property.'">
                        '.$propertyOptions.'
                        </ul>';
        }
        echo '
        <div id = "'.$newBlockId.'" class = "d_editor_block" data-class-width = "w100" ondragstart="aDrag(this);" ondragenter="aInsert(this);aSetDragged()" ondragend="aRelease()" ondrop="aRelease()" tabindex = "0" onfocusout = "dEditorBlockUpdate(this)">'.$returnHtml.'
            <div class = "d_editor_buttons">
                <div class = "d_editor_grabber" draggable="true"> : : : </div>
                '.$addButton.'
                <div class = "d_editor_trash" wire:click="blockDelete(\''.$newBlockId.'\');"><i class="fa fa-trash-o"></i></div>
                <div class="d_editor_common d_editor_properties"><i class="fa fa-ellipsis-h" onclick = "dEditorProperties(this.parentNode)"></i><i class="fa fa-close" onclick = "this.parentNode.classList.remove(\'opened\');"></i>
                    <div class="block_properties">
                    '.$propertyBlocks.'
                    </div>                
                </div>
            </div>
        </div>';
        exit;
    }
    public static function drawFigure($dataFigure, $figureContent = null)
    {
        $figImageId = str_replace('_content_', '_figure_image_', $dataFigure['editor_content_id']);
        $figImageCaptionId = str_replace('_content_', '_figure_image_caption_', $dataFigure['editor_content_id']);
        unset($dataFigure['editor_content_id']);
        $fCaption = '';
        $newFigure = new \stdClass();
        $newFigure->attribs = [];
        self::getAttribs('figure', $dataFigure);
        foreach($dataFigure as $attribName => $attribValue)
        {
            $newFigure->attribs[] = $attribName.'="'.$attribValue.'"';
        }
        if($dataFigure['data-image-caption'] === 'checked')
        {
            $fCaption = '<div class="d_editor_fig_caption" id="'.$figImageCaptionId.'" contenteditable="true">'.$dataFigure['data-image-caption-text'].'</div>';
        }
        if(isset($figureContent))
        {
            $currentDom = new \DOMDocument();
            $currentDom->loadHTML('<?xml encoding="utf-8" ?>'.$figureContent);
            $figureImage = $currentDom->getElementById($figImageId);
            foreach($figureImage->attributes as $attrib)
            {
                switch($attrib->nodeName)
                {
                    case 'alt':
                    {
                        $alt = $attrib->nodeValue;
                        break;
                    }
                    case 'src':
                    {
                        $src = $attrib->nodeValue;
                        break;
                    }
                }
            }
        }
        else
        {
            $alt = '';
            $src = '';
        }
        $newFigure->content = '
            <img class = "d_editor_fig_image" id = "'.$figImageId.'" src="'.$src.'" alt="'.$alt.'">
            '.$fCaption;
        return $newFigure;
    }
    public static function drawTable($dataTable, $tableContent = null)
    {
        $editorContentId = $dataTable['editor_content_id'];
        unset($dataTable['editor_content_id']);
        $tHeadRows = [];
        $tBodyRows = [];
        if(isset($tableContent))
        {
            $currentDom = new \DOMDocument();
            $currentDom->loadHTML('<?xml encoding="utf-8" ?>'.$tableContent);
            $tHead = $currentDom->getElementsByTagName('thead');
            if(isset($tHead) && isset($tHead[0]))
            {
                $tHeadTrs = $tHead[0]->getElementsByTagName('tr');
            }
            else
            {
                $tHeadTrs = [];
            }
            $tBody = $currentDom->getElementsByTagName('tbody');
            $tBodyTrs = $tBody[0]->getElementsByTagName('tr');
            $rowHeaderExists = false;
            foreach($tBodyTrs as $tBodyTr)
            {
                $tBodyRow = 
                [
                    'cells' => []
                ];
                foreach($tBodyTr->childNodes as $childNode)
                {
                    switch(strtolower($childNode->nodeName))
                    {
                        case 'th':
                        {
                            $rowHeaderExists = true;
                            $tBodyRow['rowHead'] = $childNode;//->saveHTML();
                            break;
                        }
                        case 'td':
                        {
                            $tBodyRow['cells'][] = $childNode;//->saveHTML();
                            break;
                        }
                        default:
                        {
                            break;
                        }
                    }
                }
                $tBodyRows[] = $tBodyRow;
            }
            $tHeadTrs = $currentDom->getElementsByTagName('thead');
            foreach($tHeadTrs as $tHeadTr)
            {
                $tHeadRow = 
                [
                    'cells' => []
                ];
                foreach($tHeadTr->childNodes as $childNode)
                {
                    switch(strtolower($childNode->nodeName))
                    {
                        case 'th':
                        case 'td':
                        {
                            if($rowHeaderExists)
                            {
                                $tBodyRow['rowHead'] = $childNode;
                            }
                            else
                            {
                                $tBodyRow['cells'][] = $childNode;
                            }
                            break;
                        }
                        default:
                        {
                            break;
                        }
                    }
                }
                $tHeadRows[] = $tHeadRow;
            }
        }
        $cellCounter = 0;
        $tHead = '';
        $tBody = '';
        $tCaption = '';
        $newTable = new \stdClass();
        $newTable->attribs = [];
        self::getAttribs('table', $dataTable);
        foreach($dataTable as $attribName => $attribValue)
        {
            $newTable->attribs[] = $attribName.'="'.$attribValue.'"';
        }
        if($dataTable['data-table-caption'])
        {
            $newTable->attribs[] = 'data-table-caption="true"';
            $newTable->attribs[] = 'data-table-caption-text="'.str_replace("'", '&#39;', htmlentities($dataTable['data-table-caption-text'])).'"';
            $tCaption = '<caption>'.$dataTable['data-table-caption-text'].'</caption>';
        }
        if($dataTable['data-table-col-head'])
        {
            $newTable->attribs[] = 'data-table-col-head="true"';
            $tHead = '
            <thead>
                <tr>';
            if($dataTable['data-table-row-head'])
            {
                $cellId = $editorContentId.'_'.$cellCounter;
                if(isset($tHeadRows[0]['rowHead']))
                {
                    $childNode = $tHeadRows[0]['rowHead'];
                    $childDom = new \DOMDocument();
                    $childDom->appendChild($childDom->importNode($childNode, true));
                    $tHead .= $childDom->saveHTML();
                }
                else
                {
                    $tHead .= '
                    <th class = "d_editor_head_cr"><div id = "'.$cellId.'" data-tmce-reset="true" contenteditable = "true"></div></th>';
                }
                $cellCounter++;
            }
            for($x = 0; $x < $dataTable['data-table-col']; $x++)
            {
                $cellId = $editorContentId.'_'.$cellCounter;
                if(isset($tHeadRows[0]['cells'][$x]))
                {
                    $childNode = $tHeadRows[0]['cells'][$x];
                    if($childNode->firstElementChild->getAttribute('id') !== $cellId)
                    {
                        $childNode->firstElementChild->setAttribute('id', $cellId);
                    }
                    $childDom = new \DOMDocument();
                    $childDom->appendChild($childDom->importNode($childNode, true));
                    $tHead .= $childDom->saveHTML();
                }
                else
                {
                    $tHead .= '
                    <th class = "d_editor_head_c"><div  id = "'.$cellId.'" data-tmce-reset="true" contenteditable = "true" onmouseenter="tmceInit(this)">Spalte '.($x + 1).'</div></th>';
                }
                
                $cellCounter++;
            }
            $tHead .= '
                </tr>
            </thead>';
        }
        if($dataTable['data-table-row-head'])
        {
            $newTable->attribs[] = 'data-table-row-head="true"';
        }
        for($y = 0; $y < $dataTable['data-table-row']; $y++)
        {
            $tBody .= '
                <tr>';
            if($dataTable['data-table-row-head'])
            {
                $cellId = $editorContentId.'_'.$cellCounter;
                if(isset($tBodyRows[$y]['rowHead']))
                {
                    $childNode = $tBodyRows[$y]['rowHead'];
                    if($childNode->firstElementChild->getAttribute('id') !== $cellId)
                    {
                        $childNode->firstElementChild->setAttribute('id', $cellId);
                    }
                    $childDom = new \DOMDocument();
                    $childDom->appendChild($childDom->importNode($childNode, true));
                    $tBody .= $childDom->saveHTML();
                }
                else
                {
                    $tBody .= '
                    <th class = "d_editor_head_r"><div id = "'.$editorContentId.'_'.$cellCounter.'" data-tmce-reset="true" contenteditable = "true" onmouseenter="tmceInit(this)">Zeile '.($y + 1).'</div></th>';                    
                }
                
                $cellCounter++;
            }
            for($x = 0; $x < $dataTable['data-table-col']; $x++)
            {
                $cellId = $editorContentId.'_'.$cellCounter;
                if(isset($tBodyRows[$y]['cells'][$x]))
                {
                    $childNode = $tBodyRows[$y]['cells'][$x];
                    if($childNode->firstElementChild->getAttribute('id') !== $cellId)
                    {
                        $childNode->firstElementChild->setAttribute('id', $cellId);
                    }
                    $childDom = new \DOMDocument();
                    $childDom->appendChild($childDom->importNode($childNode, true));
                    $tBody .= $childDom->saveHTML();
/*
//                  $tBody .= $tBodyRows[$y]['cells'][$x];
                    if($tBodyRows[$y]['cells'][$x]->getAttribute('id') !== $cellId)
                    {
                        $tBodyRows[$y]['cells'][$x]->setAttribute('id', $cellId);
                    }
                    $tBody .= $tBodyRows[$y]['cells'][$x]->saveHTML();*/
                }
                else
                {
                    $value = 'Zelle '.(($y * $dataTable['data-table-col']) + $x + 1);
                    $tBody .= '
                    <td class = "d_editor_cell"><div id = "'.$editorContentId.'_'.$cellCounter.'" data-tmce-reset="true" contenteditable = "true" onmouseenter="tmceInit(this)">'.$value.'</div></td>';
                }
                $cellCounter++;
            }
            $tBody .= '
                </tr>';
        }
        $newTable->content = '
        '.$tCaption.'
        <table class = "d_editor_table">
            '.$tHead.'
            <tbody>
            '.$tBody.'
            </tbody>
        </table>';
        return $newTable;
    }
    private static function getAttribs($blockType, &$editorAttribs)
    {
        $ec = new EditorController();
        switch($blockType)
        {
            case 'figure':
            {
                $block = $ec->dataFigure;
                break;
            }
            case 'figure':
            {
                $block = $ec->dataTable;
                break;
            }
            default:
            {
                $block = [];
                break;
            }
        }
        foreach($block as $attribName => $attribValue)
        {
            if(!isset($editorAttribs[$attribName]))
            {
                $editorAttribs[$attribName] = $attribValue;
            }
        }
    }
    public static function getClassValues()
    {
        return self::$classValues;
    }
    public function index($id, Request $req)
    {
/*        $viewParams = 
        [
            'siteTree' => null,
            'site' => $this->getUserSite($id)
        ];
        
        return view('d_editor.index', $viewParams);*/
    }
    public function siteCmenu(Request $req)
    {
        echo view('d_editor.contextmenu');
    }
}
