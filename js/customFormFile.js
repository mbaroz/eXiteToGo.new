var frm = false;
var data_sent = 0;
var uploaders = [];
var uploadersi = 0;
var allowed_photo_types = '*.jpeg;*.jpg;*.gif;*.png;*.doc;*.docx;*.pdf;*.txt;*.xls;*.ppt';

function formshowuploader(ftypes,numfiles,buttonID,cancelButtonID,progressTargetID) {
 	if (!numfiles) numfiles=200;
 	if (!ftypes) ftypes= "*.jpg;*.gif;*.png;*.swf;*.ico";
 	if (!buttonID) buttonID= "spanButtonPlaceHolder";
	if (!cancelButtonID) cancelButtonID= "btnCancel";
	if (!progressTargetID) progressTargetID= "fsUploadProgress";

 	settings = {
		flash_url : siteURL+"/Admin/uploader/swfupload.swf",
		upload_url: siteURL+"/saveUploadedFile.php",
		file_size_limit : "100 MB",
		file_types : ftypes,
		file_types_description : "Media Files",
		file_upload_limit : numfiles,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : progressTargetID,
			cancelButtonId : cancelButtonID
		},
		debug: false,
		// Button settings
		button_width: "77",
		button_height: "23",
		button_placeholder_id: buttonID,
		button_image_url: siteURL+"/Admin/uploader/images/selectfiles_org.png",
		button_text_left_padding: 4,
		button_text_right_padding: 4,
		
		button_cursor: SWFUpload.CURSOR.HAND,
		// The event handler functions are defined in handlers.js
		file_queued_handler : formfileQueued,
		file_queue_error_handler : formfileQueueError,
		file_dialog_complete_handler : formfileDialogComplete,
		upload_start_handler : formuploadStart,
		upload_progress_handler : formuploadProgress,
		upload_error_handler : formuploadError,
		upload_success_handler : formuploadSuccess,
		upload_complete_handler : formuploadComplete,
		queue_complete_handler : formqueueComplete	// Queue plugin event
	};
	
	
	return new SWFUpload(settings);
}

function FormUpdateUploadedFile(uploadedfile,original_name,input_id) {
	jQuery('input[name='+input_id+']').val(uploadedfile);
}

jQuery(function(){
	jQuery('.customFormDate').datepicker({'dateFormat':'dd.mm.yy'});
	jQuery('.formFile').each(function(){
		uploaders[uploadersi] = formshowuploader(allowed_photo_types,1,jQuery(this).attr('id'),0,'progress_'+jQuery(this).attr('id'));
		uploadersi++;
	});
});

function beforeFormSubmit() {
	if(data_sent == 0)
	{
		data_sent = 1;
		jQuery.each(uploaders,function(index,uploader){
			uploader.startUpload();
		});
		setTimeout('checkBeforeFormSumbit()',500);
	}
}

function checkBeforeFormSumbit() {
	var notuploaded = 0;
	jQuery.each(uploaders,function(index,uploader){
		var stat = uploader.getStats();
		if(stat.in_progress == 1 || stat.files_queued > 0)
			notuploaded++;
	});
	if(notuploaded == 0)
		doSubmitForm();
	else
		setTimeout('checkBeforeFormSumbit()',500);
}
var frm_button_css_bg;
var frm_button_val;
function waitForForm(start) {
	if (start==1) {
		jQuery("input[type=submit].frm_button").removeAttr("disabled");
		jQuery("input[type=submit].frm_button").val(frm_button_val);
		jQuery("input[type=submit].frm_button").css("background-image",frm_button_css_bg);
	}
	else {
		frm_button_css_bg=jQuery("input[type=submit].frm_button").css("background-image");
		frm_button_val=jQuery("input[type=submit].frm_button").val();
		
		jQuery("input[type=submit].frm_button").attr("disabled","disabled");
		jQuery("input[type=submit].frm_button").val(waitForSendLabel);
		jQuery("input[type=submit].frm_button").css("background-image","none");
	}
}

function submitForm(frmi){
	frm = frmi;
	Placeholder.submitted(frm);
	waitForForm(0);
	if(!hasFiles)
	{
		doSubmitForm();
		return false;
	}
	else
	{
		//jQuery(frm).submit();
		beforeFormSubmit();
		return false;
	}
}

function doSubmitForm() {
	var pars = jQuery(frm).serialize();
	jQuery.ajax({
		type: "POST",
		url: siteURL+"/sendCustomForm.php",
		data: pars,
		success: function(msg){
			jQuery('#form_result').html(msg);
			Placeholder.init({normal:"#"+inputTextColor});
			data_sent = 0;
			window.setTimeout('waitForForm(1)',2200);
		}
	});
}