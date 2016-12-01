<?
?>
<script language="javascript">
var swfu;
var swfu_2;
var settings;


	 function showuploader(ftypes,numfiles,buttonID,cancelButtonID,progressTargetID,instance_num) {
	 	if (!numfiles) numfiles=200;
	 	if (!ftypes) ftypes= "*.jpg;*.gif;*.png;*.swf;*.ico;*.mp4";
	 	if (!buttonID) buttonID= "spanButtonPlaceHolder";
		if (!cancelButtonID) cancelButtonID= "btnCancel";
		if (!progressTargetID) progressTargetID= "fsUploadProgress";

	 	settings = {
		flash_url : "<?=$SITE[url];?>/Admin/uploader/swfupload.swf",
		upload_url: "<?=$SITE[url];?>/Admin/uploader/upload.php",
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
		button_width: "100",
		button_height: "33",
		button_placeholder_id: buttonID,
		button_image_url: "<?=$SITE[url];?>/Admin/uploader/images/selectfiles.png",
		button_text_left_padding: 4,
		button_text_right_padding: 4,
		button_cursor: SWFUpload.CURSOR.HAND,
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	// Queue plugin event
			};
		
		
		if (instance_num) swfu_2 = new SWFUpload(settings);
		else swfu = new SWFUpload(settings);
	}
	
</script>