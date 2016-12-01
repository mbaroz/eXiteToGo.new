/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	config.uiColor = '#C3D9FF';
	config.enterMode=CKEDITOR.ENTER_BR;
	config.language = 'en';
	config.contentsLangDirection =SiteDirection;
	config.scayt_autoStartup = false;
	config.removePlugins= 'magicline';
	config.extraPlugins='autogrow,oembed,imagemaps';
	config.startupFocus = true;	
	config.allowedContent= true;
	config.toolbar =
			[
			  ['Source','-','Maximize'],
				['Cut','Copy','Paste','PasteText','PasteWord','Undo','Redo','Replace','Bold','Italic','Underline','FontSize','TextColor','BGColor'],
				['NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','RemoveFormat','oembed','Iframe'],
				['Link','Unlink','Image','Flash','Table','HorizontalRule','SpecialChar','FontFormat','FontName','CreateDiv','Indent','Outdent','BidiRtl','BidiLtr','Anchor','ImageMaps']
	];
	config.keystrokes =
			[
			    [ CKEDITOR.ALT + 121 /*F10*/, 'toolbarFocus' ],
			    [ CKEDITOR.ALT + 122 /*F11*/, 'elementsPathFocus' ],
			
			    [ CKEDITOR.SHIFT + 121 /*F10*/, 'contextMenu' ],
			
			    [ CKEDITOR.CTRL + 90 /*Z*/, 'undo' ],
			    [ CKEDITOR.CTRL + 89 /*Y*/, 'redo' ],
			    [ CKEDITOR.CTRL + CKEDITOR.SHIFT + 90 /*Z*/, 'redo' ],
			
			    [ CKEDITOR.CTRL + 75 /*K*/, 'link' ],
			
			    [ CKEDITOR.CTRL + 66 /*B*/, 'bold' ],
			    [ CKEDITOR.CTRL + 73 /*I*/, 'italic' ],
			    [ CKEDITOR.CTRL + 85 /*U*/, 'underline' ],
			
			    [ CKEDITOR.ALT + 109 /*-*/, 'toolbarCollapse' ]
			];
	config.width = '99%';
	config.height = 285;
	config.colorButton_enableMore = true;
	config.fontSize_sizes='8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;38/38px;45/45px;48/48px;72/72px';
};
CKEDITOR.on('dialogDefinition', function( ev ) {
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  if(dialogName === 'table') {
    var infoTab = dialogDefinition.getContents('info');
    var border = infoTab.get('txtBorder');
    border['default'] = "0";
  }
  if(dialogName === 'image') {
    var infoTab = dialogDefinition.getContents('info');
   var border = infoTab.get('txtBorder');
    border['default'] = '0';
  }
});