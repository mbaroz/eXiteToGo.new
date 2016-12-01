CKEDITOR.dialog.add('hidemobileDialog', function(editor) {
    return {
        title: 'Mobile behaviour',
        icons: 'hidemobile',
        width: 200,
        height: 200,
        resizeable: false,

        onOk: function(event) {
            elementId = 'mobileBehaviourType';
            behaviourType = this.getContentElement( 'tab-basic', 'mobileBehaviourType').getValue();

            editor.getCommand('set' + behaviourType + 'Command').exec();
        },

        contents: [
            {
                id: 'tab-basic',
                label: 'Mobile settings',
                elements: [
                    {
                        type: 'html',
                        html: '<p><strong>Here you can define what is displayed on mobile devices.</strong><br/><br/>' +
                            'You can choose between:<br/>' +
                            ' - show block always<br/>' +
                            ' - show only on mobile devices<br/>' +
                            ' - hide on mobile devices<br/>' +
                            '<br/>' +
                            '' +
                            '</b>'
                    },
                    {
                        type: 'select',
                        id: 'mobileBehaviourType',
                        label: 'Mobile behaviour',
                        'default': 'DefaultBehaviour',
                        items: [['Show always (default)', 'DefaultBehaviour'], ['Hide on mobile devices', 'HideMobile'], ['Show only on mobile devices', 'MobileOnly']],
                        validate: CKEDITOR.dialog.validate.notEmpty( "Abbreviation field cannot be empty" )
                    }
//                    {
//                        type: 'html',
//                        label: "<p>asd</p>",
//                        id: 'mobileBehaviourDialogDescription'
//                    }
                ]
            }
        ]
    };
})