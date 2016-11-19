var imageWidget;

jQuery(document).ready(function($){
    imageWidget = {

        // Call this from the upload button to initiate the upload frame.
        uploader : function( widget_id_string, selected_media_id ) {

            var frame = wp.media({
                title : 'News Contact',
                multiple : false,
                library : { type : 'image' },
                button : { text : 'Insert Image Into Widget' }
            });

            // Handle results from media manager.
            frame.on('close',function( ) {
                var attachments = frame.state().get('selection').toJSON();
                imageWidget.render( widget_id_string, attachments[0] );
            });

            frame.open();
            return false;
        },

        // Output Image preview and populate widget form.
        render : function( widget_id_string, attachment ) {
            $("#" + widget_id_string + 'preview img').attr('src', attachment.url);
            $("#" + widget_id_string + 'attachmentID').val(attachment.id);
            $("#" + widget_id_string + 'imageURL').val(attachment.url);
        }

    };

});