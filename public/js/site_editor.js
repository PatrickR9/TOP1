var maxWaitLetters;
var waitLetterIndex = 0;
function setLetters()
{
    if(waitLetterIndex < maxWaitLetters)
    {
        d_editor_wait_letters.children[waitLetterIndex].classList.add('d_editor_wait_letter_animated');
        waitLetterIndex++;
        setTimeout(setLetters, 100);
    }
}
function startWait()
{
    if(typeof d_editor_wait_controller !== 'undefined')
    {
        d_editor_wait_controller.classList.remove('hidden');
    }
}
function stopWait()
{
    if(typeof d_editor_wait_controller !== 'undefined')
    {
        d_editor_wait_controller.classList.add('hidden');
    }
}
window.addEventListener('load', function()
{
    if(typeof _activityController !== 'undefined')
    {
//        alert('_activityController');
/*        setInterval(function()
        {
            var activityEvent = new Event('change');
            _activityController.dispatchEvent(activityEvent);
        }, 10000);*/
    }
    if(typeof d_editor_wait_letters !== 'undefined')
    {
        maxWaitLetters = d_editor_wait_letters.children.length;
        setLetters();
    }
});
window.addEventListener('beforeunload', function(event)
{
    if((siteBlocksChanged) && (typeof _activityController !== 'undefined'))
    {
        event.preventDefault();
        var activityEvent = new Event('click');
        _activityController.dispatchEvent(activityEvent);
    }
});
window.addEventListener('load', function()
{
	stopWait();
});