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

$("#AES").change(function() {
    if ($(this).prop("checked") == true) {

        $(this).val('true');
        $('#RSA').val('false');

        if ($('#IvInputFile').is(":visible")) {
            $('#IvInputFile').attr('style', 'pointer-events:auto');
            $('#IvInputFile').attr('style', 'opacity:1.0');
        } else {
            $('#IvInputText').attr('style', 'pointer-events:auto');
            $('#IvInputText').attr('style', 'opacity:1.0');
        }
        $('#IVOptions').attr('style', 'pointer-events:auto');
        $('#IVOptions').removeAttr('disabled');
        $('#IVOptions').attr('style', 'opacity:1.0');
    }
});

$("#RSA").change(function() {
    if ($(this).prop("checked") == true) {

        $(this).val('true');
        $('#AES').val('false');

        if ($('#IvInputFile').is(":visible")) {

            $('#IvInputFile').attr('style', 'pointer-events:none');
            $('#IvInputFile').attr('style', 'opacity:0.4');

        } else {
            $('#IvInputText').attr('style', 'pointer-events:none');
            $('#IvInputText').attr('style', 'opacity:0.4');

        }
        $('#IVOptions').attr('style', 'pointer-events:none');
        $('#IVOptions').attr('disabled', 'disabled');
        $('#IVOptions').attr('style', 'opacity:0.4');
    }
});
