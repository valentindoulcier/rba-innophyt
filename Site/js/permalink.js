/*###########################*/
/***** NOT IMPLEMENTED ! *****/
/*###########################*/

var PERMALINK_QESTID_FIELD_ID = '#permalinkQuestionId';

function permalinkCopy()
{
	copyToClipboard('?questionid='+$(PERMALINK_QESTID_FIELD_ID).attr('value'));
}

function setPermalinkQuestionId(questionId)
{
	$(PERMALINK_QESTID_FIELD_ID).attr('value', questionId);
}

function copyToClipboard (text) {
  window.prompt ("Ctrl+C pour copier dans le presse papier", text);
}
