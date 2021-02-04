$(document).ready(function () {
    //Show secret
    $(document).on('click', '#secret-add-btn', function (e) {
        e.preventDefault();
        $.ajax({
            url: "ajax.php",
            method: "POST",
            data: {type: 1},
            success: function (dataResult) {
                $('#secret').html(dataResult);
            }
        });
    });
    // Delete
    $(document).on('click', '#showid', function (e) {
        e.preventDefault();
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                type: 2,
                id: $("#idd").val()
            },
            success: function (dataResult) {
                $('#info').html(dataResult);
            }
        });
    });
});