/* EASY DRAG & DROP */
var aGrabbedElem;
var aTargetElem;
var siteBlocksChanged = false;
var tmceInitializedBlocks = [];

function aDragCopy(thisElem, copyFromClass)
{
	if(thisElem.parentNode.classList.contains(copyFromClass))
	{
		aGrabbedElem = thisElem.cloneNode(true);
		aGrabbedElem.id += '_new';
		aGrabbedElem.classList.remove('d_property_component');
		aGrabbedElem.classList.add('d_editor_block');
		aGrabbedElem.classList.add('d_editor_block_padding');
		aGrabbedElem.classList.add('w100');
	}
	else
	{
		aGrabbedElem = thisElem;
	}
	aTargetElem = aGrabbedElem;
}
function aDrag(thisElem)
{
	thisElem.classList.add('a_dragged');
	aGrabbedElem = thisElem;
	aTargetElem = thisElem;
}
function aDragOver(e, thisElem)
{
	e.preventDefault()
	thisElem.classList.add('a_dragged_mode');
}
function aInsert(thisElem)
{
	let dropEnabled = true;
	if(thisElem.hasAttribute('data-drop'))
	{
		dropEnabled = (thisElem.getAttribute('data-drop') == aTargetElem.getAttribute('data-drop'));
	}
	if(dropEnabled && !aTargetElem.isSameNode(thisElem))
	{
		aTargetElem = thisElem;
		if(thisElem.isSameNode(aGrabbedElem.previousElementSibling) || (thisElem.id === 'd_editor_cover'))
		{
			thisElem.parentNode.insertBefore(aGrabbedElem, thisElem);
		}
		else
		{
			if(thisElem.isSameNode(aGrabbedElem.nextElementSibling) && !thisElem.parentNode.lastElementChild.isSameNode(aGrabbedElem.nextElementSibling))
			{
				thisElem.parentNode.insertBefore(aGrabbedElem, thisElem.nextElementSibling);
			}
			else
			{
				thisElem.parentNode.insertBefore(aGrabbedElem, thisElem);
			}
		} 
	}
}
function aInsertPrepare(thisElem)
{
/*	if(aGrabbedElem.parentNode === null)
	{
		thisElem.appendChild(aGrabbedElem);
		aTargetElem = thisElem.children[0];
	}*/
}
function aRelease()
{
	aGrabbedElem.classList.remove('a_dragged');
    aTargetElem.parentNode.classList.remove('a_dragged_mode');
	dEditorBlockUpdate(aGrabbedElem);
	siteBlocksChanged = true;
}
function aReleaseNew()
{
	aGrabbedElem.children[0].innerText = '';
	aGrabbedElem.children[0].className = 'd_property_icon fa fa-spinner fa-pulse';
	let formToSend = new FormData(document.getElementById(aGrabbedElem.getAttribute('data-form')));
	let d = new Date();
	formToSend.append('dBlockId', aGrabbedElem.id);
	formToSend.append('dTimeStamp', d.valueOf());
	let req = new XMLHttpRequest();
	req.onreadystatechange = function()
	{
		if((req.readyState === 4) && (req.status === 200) && (aGrabbedElem.parentElement !== null))
		{
			let changeableElem = aGrabbedElem.parentElement.querySelector('.a_dragged');
			let newBlock = document.createElement('div');
			newBlock.innerHTML = req.responseText;
			let newBlockId = newBlock.children[0].id;
			changeableElem.replaceWith(newBlock.children[0]);
			aGrabbedElem.classList.remove('a_dragged');
			aTargetElem.parentNode.classList.remove('a_dragged_mode');
			siteBlocksChanged = true;
			dEditorBlockUpdate(document.getElementById(newBlockId));
		}
	}
	req.open('POST', '/dc_insert');
	req.send(formToSend);
}
function aSetDragged()
{
	if(!aGrabbedElem.classList.contains('a_dragged'))
	{
		aGrabbedElem.classList.add('a_dragged');
	}
}
var currentBlockIdToUpdate;
function dEditorBlockUpdate(thisBlock)
{
	console.log(siteBlocksChanged);
	if(siteBlocksChanged === true)
	{
		currentBlockIdToUpdate = thisBlock.id;
		let dEditorBlocks = thisBlock.parentNode.querySelectorAll('.d_editor_block');
		let blockIds = [];
		for(let i = 0; i < dEditorBlocks.length; i++)
		{
			blockIds.push(dEditorBlocks[i].id);
		}
		currentBlockContent.value = thisBlock.innerHTML;
		currentEditedSiteBlockIds.value = JSON.stringify(blockIds);
		var myEvent = new Event('change');
		currentEditedSiteBlockIds.dispatchEvent(myEvent);
		siteBlocksChanged = false;
	}
}
function dEditorProperties(thisBox)
{
	if(!thisBox.classList.contains('opened'))
	{
		let openedProperties = d_editor.querySelectorAll('.d_editor_properties.opened');
		for(let i = 0; i < openedProperties.length; i++)
		{
			openedProperties[i].classList.remove('opened');
		}
		thisBox.classList.add('opened');
	}
}
function dEditorPopupClose()
{
	alert('dEditorPopupClose');
	if(typeof(d_editor_popup)!== undefined)
	{
		d_editor_popup.remove();
	}
}
function editDBlock(thisBlock)
{
	alert('editDBlock');
/*	if(thisBlock.hasAttribute('data-tmc-initialized'))
	{
		if(thisBlock.hasAttribute('data-content-type'))
		{
			let dContentType = thisBlock.getAttribute('data-content-type');
			switch(dContentType)
			{
				case 'text':
				{
					thisBlock.focus();
					break;
				}
				case 'figure':
				{
					let figCaptionId = thisBlock.id.replace('_content_', '_fig_caption_');
					document.getElementById(figCaptionId).focus();
					break;
				}
			}
		}
	}
	else
	{
		tmceInitializedBlocks = [];
		thisBlock.setAttribute('data-tmc-initialized', true);
		tmceInit(thisBlock);
	}*/
}
function setBlockAttributes(id, attribsName, attribValue)
{
	alert(attribsName);
}
function setAttribStatus()
{
	alert('dEditorPopupClose');
	siteBlocksChanged = true;
	d_editor.classList.add('d_editor_locked');
}
/*function siteEditStart(thisInput)
{
	console.log(thisInput.previousElementSibling);
	thisInput.previousElementSibling.setAttribute('contenteditable', true);
	thisInput.previousElementSibling.focus();
	if(thisInput.classList.contains('fa-pencil'))
	{
		thisInput.classList.replace('fa-pencil', 'fa-check');
	}
	else
	{
		thisInput.classList.replace('fa-check', 'fa-pencil');
	}
}
function siteMapMenu(e, id)
{
	let contentPosX = e.pageX;
	let contentPosY = e.pageY;
	let formToSend = new FormData(document.getElementById('d_property_component_form'));
	let d = new Date();
	formToSend.append('dTimeStamp', d.valueOf());
	formToSend.append('id', id);
	let req = new XMLHttpRequest();
	req.onreadystatechange = function()
	{
		if((req.readyState === 4) && (req.status === 200))
		{
			d_editor_popup.innerHTML = req.response;
			let contentWidth = d_editor_popup.children[0].scrollWidth;
			let contentHeight = d_editor_popup.children[0].scrollHeight;
			if((contentPosX + contentWidth) > window.innerWidth)
			{
				d_editor_popup.children[0].style.right = (window.innerWidth - contentPosX) + 'px';
			}
			else
			{
				d_editor_popup.children[0].style.left = contentPosX + 'px';
			}
			if((contentPosY + contentHeight) > window.innerHeight)
			{
				d_editor_popup.children[0].style.bottom = (window.innerHeight - contentPosY) + 'px';
			}
			else
			{
				d_editor_popup.children[0].style.top = contentPosY + 'px';
			}
			d_editor_popup.classList.remove('hidden');
		}
	}
	req.open('POST', '/site_cmenu');
	req.send(formToSend);
}
function siteRename(thisInput, id)
{
	if(thisInput.isContentEditable && thisInput.hasAttribute('data-contentedited'))
	{
		thisInput.removeAttribute('contenteditable');
		thisInput.removeAttribute('data-contentedited')
		let formToSend = new FormData(document.getElementById('d_property_component_form'));
		let d = new Date();
		formToSend.append('dTimeStamp', d.valueOf());
		formToSend.append('id', id);
		formToSend.append('title', thisInput.textContent);
		let req = new XMLHttpRequest();
		req.onreadystatechange = function()
		{
			if((req.readyState === 4) && (req.status === 200))
			{
				console.log(req.response);
			}
		}
		req.open('POST', '/site_update');
		req.send(formToSend);
	}
}*/

function siteSave(toNext)
{
	let contentBlocks = d_editor.querySelectorAll('.d_editor_box');
	let dEditorBoxes = {};
	for(let i = 0; i < contentBlocks.length; i++)
	{
		dEditorBoxes[contentBlocks[i].id] = contentBlocks[i].outerHTML; 
	}
	Livewire.dispatch('saveAndNext',{'dEditorBoxes':dEditorBoxes, 'toNext':toNext})
}
function tmceInit(thisInput)
{
	if(typeof tmceInitializedBlocks[thisInput.id] === 'undefined')
	{
		tmceInitializedBlocks[thisInput.id] = false;
	}
	if(thisInput.hasAttribute('data-tmce-reset'))// || tmceInitializedBlocks[thisInput.id])
	{
		tmceInitializedBlocks[thisInput.id] = false;
		thisInput.removeAttribute('data-tmce-reset');
		let thisInputId = '#'.concat(thisInput.id);
		tinymce.remove(thisInputId);
	}
	if(tmceInitializedBlocks[thisInput.id] === false)
	{
		let thisInputId = '#'.concat(thisInput.id);
		tinymce.init({
			selector: thisInputId,
			license_key: 'gpl',
			// TinyMCE configuration options
			inline: true,
			content_css: false,
			promotion: false,
			setup: function(editor) {
				// controlls changes in editor
				editor.on('init', function()
				{
				});
				editor.on('change', function() 
				{
				//	siteBlocksChanged = true;
				});
			}
		});
		tmceInitializedBlocks[thisInput.id] = true;
	}
}
function toggleAccordion(thisButton)
{
	let accordionBlock = thisButton.nextElementSibling;
	if(accordionBlock.classList.contains('accordion_block_closed'))
	{
		accordionBlock.style.maxHeight = '0px';
		thisButton.classList.remove('accordion_button_closed');
		accordionBlock.classList.remove('accordion_block_closed');
		setTimeout(function(){
			accordionBlock.style.maxHeight = accordionBlock.scrollHeight + 'px';
			setTimeout(function(){
				accordionBlock.style.maxHeight = 'none';
			}, 280);
		}, 100);
	}
	else
	{
		accordionBlock.style.maxHeight = accordionBlock.scrollHeight + 'px';
		thisButton.classList.add('accordion_button_closed');
		accordionBlock.classList.add('accordion_block_closed');
		setTimeout(function(){
			accordionBlock.style.maxHeight = '0px';
		}, 100);
	}
}
