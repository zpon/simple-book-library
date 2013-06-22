$(function() {
    $(".delete-owner").click(function() {
        console.log("hej");
        var ref = $(this).data('href');

        showDeleteDialog(ref, 'Confirm deletion', 'Are you sure you want to delete this owner?\nAll book copies who has this owner added will get it removed.');
    });
});