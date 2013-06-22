/**
 * Show warning dialog
 * 
 * @param {type} href Link to go to if users clicks on the delete button
 * @param {type} title Title text
 * @param {type} message Warning message. "\n" will be converted to "<br/>"
 */
function showDeleteDialog(href, title, message) {
    $("#delete-modal-label").text(title);
    message.replace("\n", "<br/>");
    $("#delete-modal-body p").html(message);
    $("#delete-modal .actual-delete").attr("href", href);
    $("#delete-modal").modal();
}