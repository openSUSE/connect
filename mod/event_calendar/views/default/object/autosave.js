/* Here i include the nessecary js files so as to interact with jquerry and TinyMCE editor */

include('/home/zoumpis/connect/vendors/jquery/jquery-1.3.2.min.js');
include('/home/zoumpis/connect/vendors/jquery/jquery-ui-1.7.2.custom.min.js');
include('/home/zoumpis/connect/vendors/jquery/jquery-ui-1.7.2.min.js');
include('/home/zoumpis/connect/vendors/jquery/jquery.autocomplete.min.js');
include('/home/zoumpis/connect/vendors/jquery/jquery.easing.1.3.packed.js');
include('/home/zoumpis/connect/vendors/jquery/jquery.form.js');
include('/home/zoumpis/connect/mod/tinymce/tinymce/jscripts/tiny_mce.js');

// Here is the auto_save() function that will be called every 30 secs
function auto_save(editor_id) {
	// First we check if any changes have been made to the editor window
	if(tinyMCE.getInstanceById(editor_id).isDirty()) {
		// If so, then we start the auto-save process
		// First we get the content in the editor window and make it URL friendly
		var content = tinyMCE.get(editor_id);
		var notDirty = tinyMCE.get(editor_id);
		content = escape(content.getContent());
		content = content.replace("+", "%2B");
		content = content.replace("/", "%2F");
		// We then start our jQuery AJAX function
		$.ajax({
			url: "save.php", // the path/name that will process our request
			type: "POST", 
			data: "content=" + content, 
			success: function(msg) {
				alert(msg);
				// Here we reset the editor's changed (dirty) status
				// This prevents the editor from performing another auto-save
				// until more changes are made
				notDirty.isNotDirty = true;
			}
		});
	// If nothing has changed, don't do anything
	} else {
		return false;
	}
}

function auto_load(editor_id) {
	// First we assign our editor window to a variable
	var ed = tinyMCE.get(editor_id);
	
	// Then we start our AJAX jQuery function
	$.ajax({
		url: "load.php", // the path/name that will recover our content
		beforeSend: function() {
			ed.setProgressState(1);
		},
		success: function(msg) {
			ed.setContent(msg);
			ed.setProgressState(0);
		}
	});
}



