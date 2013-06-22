$(function() {
    $(".delete-location").click(function() {
        var ref = $(this).data('href');

        showDeleteDialog(ref, 'Confirm deletion', 'Are you sure you want to delete this location?\n<br/>All book copies currently added to this location will get their location removed.');
    });
});