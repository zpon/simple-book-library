$(function() {
    $("#add-isbn-lookup").click(function() {
        // Test ISBN number 9780470430668
        var isbnNumber = $("input[name='isbn']").val();
        isbnNumber = isbnNumber.replace(/[^0-9]+/gi, ''); // Removed illegal letters, e.g. "-".
        $("input[name='isbn']").val(isbnNumber);
        if (isbnNumber.length > 0) {
            $.ajax({
                url: serverUrl + "/library/isbn_lookup/" + isbnNumber,
                dataType: "json",
                success: function(data) {
                    $("input[name='author']").val(data['author']);
                    $("input[name='title']").val(data['title']);
                    $("input[name='year']").val(data['year']);
                    $("textarea[name='summary']").val(data['summary']);

                    var message = "<a target=\"_blank\" href=\"http://www.amazon.com/gp/search/?search-alias=stripbooks&field-isbn=" + isbnNumber + "\">Amazon link</a>";
                    if (data['title'].length == 0 && data['author'].length == 0 && data['summary'].length == 0) {
                        message = "Was unable to lookup book, try this " + message;
                    }
                    $("div.further-info").html(message);
                    $("div.further-info").slideDown();
                },
                error: function(jqXHR) {
                    console.log("Error");
                    console.log(jqXHR);
                    $("div.further-info").html("Something went wrong during lookup, please try again.");
                    $("div.further-info").slideDown();
                }
            });
        } else {
            $("div.further-info").html("Please enter an ISBN number first.");
            $("div.further-info").slideDown();
        }
    });
});