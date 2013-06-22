$(function() {
    $(".delete-book").click(function() {
        var ref = $(this).data('href');

        showDeleteDialog(ref, 'Confirm deletion', 'Are you sure that you want to delete this book and all its copies?');
    });

    function showDeleteDialog(href, title, message) {
        $("#delete-modal-label").text(title);
        $("#delete-modal-body p").text(message);
        $("#delete-modal .actual-delete").attr("href", href);
        $("#delete-modal").modal();
    }
});