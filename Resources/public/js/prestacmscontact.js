$(document).ready(function() {

    // Attach a submit handler to the form
    $( "#contact_form" ).submit(function( event ) {
        // Stop form from submitting normally
        event.preventDefault();

        form = $( "#contact_form" );

        // Send the data using post
        var posting = $.post( form.attr( "action" ), form.serialize() );

        // Put the results in a div
        posting.done(function( data ) {
            $("#contact_form_messages").html( data );
        });
    });
});