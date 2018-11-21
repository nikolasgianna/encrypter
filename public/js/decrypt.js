$("#encFile").change(function() {
    if ($(this).prop("checked") == true) {

        $('#encInputText').hide();
        $('#encInputFile').show();
        $('#encText').prop('checked', false);
    }
});

$("#encText").change(function() {
    if ($(this).prop("checked") == true) {
        $('#encInputText').show();
        $('#encInputFile').hide();
        $('#encFile').prop('checked', false);
    }
});

$("#IVFile").change(function() {
    if ($(this).prop("checked") == true) {

        $('#IvInputText').hide();
        $('#IvInputFile').show();
        $('#IVText').prop('checked', false);

    }
});

$("#IVText").change(function() {
    if ($(this).prop("checked") == true) {
        $('#IvInputText').show();
        $('#IvInputFile').hide();
        $('#IVFile').prop('checked', false);
    }
});
