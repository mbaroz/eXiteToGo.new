CKEDITOR.plugins.add( 'aviary', {
	icons: 'aviary',
    init: function( editor) {

		var featherEditor = new Aviary.Feather({
			apiKey: '616e3a9942165e5b',
			apiVersion: 3,
			theme: 'light',
			tools: 'all',
			appendTo: '',
			onError: function(errorObj) {
				alert(errorObj.message);
			}
		});

    	editor.addCommand('aviaryCommand', {
    		exec: function(editor){
	   			var selection = editor.getSelection(), 
	   			element = selection.getSelectedElement(),
	   			src, link, path;

    			if(! element || ! element.is("img")) return;

    			src = "" + element.getAttribute("src").split("?")[0];
    			path = src.split("userfiles/images/")[1];
    			link = jQuery('<a/>', { href: src }).get(0);

				featherEditor.launch({
					image: element.$,
					url: link.href,
					postUrl: siteURL+"/Admin/saveAviaryPhoto.php",
					postData: {
						type: "ckeditor",
						source_filename: path,
					},
					onSave: function(image, imageUrl){
						element.setAttribute("data-cke-saved-src", src+"?"+new Date().getTime());
						element.setAttribute("src", imageUrl);

						featherEditor.close();
					}
				});				
    		}
    	});

    	editor.ui.addButton('Aviary', {
    		label: 'Aviary',
    		command: 'aviaryCommand',
    		toolbar: 'insert'
    	});
    }
});