;(function($){

    $('a[data-remote]').on('click', function(e){
        e.preventDefault();

        $.get($(this).data('remote'), function(comment){

            scroll('#comment_form');

            setFormData(
                '#comment_form',
                comment.content + '<footer>- '+ comment.username +'</footer>',
                comment.commentable_type,
                comment.commentable_id,
                comment.comment_id
            );

            controlTabs();
        });
    });

    $('a[data-response-comment]').on('click', function(e){
        e.preventDefault();
        var data = $(this).data();

        setFormData('#comment_form', data.travelResponseName, data.commentableType, data.travelResponseId, 0);

        controlTabs();
    });

    function setFormData(form, replyText, commentableType, commentableId, parent)
    {
        var replyElem = $('#comment_form #reply-blockquote');
        replyElem
            .closest('.hide--d')
            .removeClass('hide--d')
            .addClass('form-row');

        replyElem.html('<blockquote class="reply">' + replyText +'</blockquote>');

        $('input[name=comment_parent]', form).val(parent);
        $('input[name=commentable_type]', form).val(commentableType);
        $('input[name=commentable_id]', form).val(commentableId);
    }

    function controlTabs()
    {
        // init tabs
        var $tabContainer = $('#tab-container');

        if($tabContainer.length)
        {
            $tabContainer.easytabs('select', '#tabs1-comment');
            $tabContainer.bind('easytabs:after', function() {
                $('#comment_form .redactor_editor').focus();
            });
        }

        $('#comment_form .redactor_editor').focus();
    }

    function scroll(element){
        $('html,body').animate({ scrollTop: $(element).offset().top }, { duration: 0, easing: 'swing'});
    }

})(jQuery);