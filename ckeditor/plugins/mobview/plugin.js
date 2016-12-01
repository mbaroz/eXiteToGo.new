CKEDITOR.config.contentsCss = [CKEDITOR.config.contentsCss, '/ckeditor/plugins/mobview/style.css'];

CKEDITOR.plugins.add('mobview', {
    icons: 'hidemobile',


    init: function(editor) {
        editor.addCommand('hidemobileDialog', new CKEDITOR.dialogCommand('hidemobileDialog'))

        editor.ui.addButton( 'mobview', {
            label: 'Mobile behaviour',
            command: 'hidemobileDialog',
            // toolbar: 'insert',
            icon: this.path + 'icons/hidemobile.png'
        });
        

        CKEDITOR.dialog.add('hidemobileDialog', this.path + 'dialogs/hidemobile.js' );

        mobileOnly       = { element: 'span', overrides: [ { element: 'span', attributes: { 'class': null } } ],  attributes: {'class': 'mobileonly'}};
        hideMobile       = { element: 'span', overrides: [ { element: 'span', attributes: { 'class': null } } ],  attributes: {'class': 'hidemobile'}};
        defaultBehaviour = { element: 'span', overrides: [ { element: 'span', attributes: { 'class': null } } ],  attributes: {'class': null}};


        var mobeileOnlyStyle = new CKEDITOR.style( mobileOnly );
        var hideMobileStyle  = new CKEDITOR.style( hideMobile );
        var defaultBehaviourStyle = new CKEDITOR.style( defaultBehaviour );


        editor.addCommand( 'setMobileOnlyCommand', new CKEDITOR.styleCommand( mobeileOnlyStyle ) );
        editor.addCommand( 'setHideMobileCommand', new CKEDITOR.styleCommand( hideMobileStyle ) );
        editor.addCommand( 'setDefaultBehaviourCommand', new CKEDITOR.styleCommand( defaultBehaviourStyle ) );
    }
});

