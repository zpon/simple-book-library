/**
 * Created with JetBrains PhpStorm.
 * User: sjuul
 * Date: 4/27/13
 * Time: 3:08 PM
 * To change this template use File | Settings | File Templates.
 */
$(function() {
    var maxHeightForHiddenText = 50;
    var orgHeight = $("#summary").height();

    if (orgHeight > maxHeightForHiddenText) {
        $("#summary").height(maxHeightForHiddenText);
        $("#summary_toggle").show();
        $("#summary_fade").show();
    } else {
        $("#summary_toggle").hide();
        $("#summary_fade").hide();
    }

    $("#summary_toggle").click(function() {
        if ($("#summary").height() < orgHeight) {
            $("#summary").animate({'height': orgHeight + 'px'}, 500);
            $("#summary_toggle").fadeOut(function() {
                $("#summary_toggle").text("Show less...");
                $("#summary_toggle").fadeIn();
                $("#summary_fade").fadeOut();
            });
        } else {
            $("#summary").animate({'height': maxHeightForHiddenText + 'px'}, 500);
            $("#summary_toggle").fadeOut(function() {
                $("#summary_toggle").text("Show more...");
                $("#summary_toggle").fadeIn();
                $("#summary_fade").fadeIn();
            });
        }
    });

    var showLostCopies = false
    toggleLostBooks(showLostCopies);

    $("#toggle-lost-books").click(function() {
        if (!showLostCopies) {
            $(this).text("Hide lost copies");
        } else {
            $(this).text("Show lost copies");
        }
        showLostCopies = !showLostCopies;
        toggleLostBooks(showLostCopies);
    });

    function toggleLostBooks(show) {
        $("#copy-tables tr").each(function(index, data) {
            var lost = $(data).attr('data-lost');
            if (lost == 1) {
                if (show) {
                    $(data).show();
                } else {
                    $(data).hide();
                }
            }
        });
    }

    $("#book-delete").click(function() {
        var ref = $(this).data('href');

        showDeleteDialog(ref, 'Confirm deletion', 'Are you sure that you want to delete this book and all its copies?');
    });

    $(".delete-copy").click(function() {
        var ref = $(this).data('href');
        var additionalId = $(this).data('additional-id');

        var message = 'Are you sure that you want to delete this book copy?';
        if (additionalId.toString().length > 0) {
            message = 'Are you sure that you want to delete the book copy with additional id "' + additionalId + '"?';
        }
        
        showDeleteDialog(ref, 'Confirm deletion', message);
    });

});