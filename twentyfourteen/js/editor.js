(function($) {
    var buttons = ['link',
        '|', 'bold', 'italic',
        '|', 'orderedlist', 'unorderedlist'
    ];

    $('#comment_form textarea#content').redactor({
		minHeight: 130,
        convertDivs: false,
        wym: false,
        buttons: buttons,
        pastePlainText: true,
        removeEmptyTags: false
    });

})(jQuery);