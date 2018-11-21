$("#fileUpload").on("submit", function(e) {
    $('#fileEncryptionKeyText').val(document.getElementById("userEncryptionKeyText").value);
    if (document.getElementById("auto").value != null) {
        $('#randomTrueFile').val(document.getElementById("auto").value);
    }
});
$("#textUpload").on("submit", function(e) {
    $('#textEncryptionKeyText').val(document.getElementById("userEncryptionKeyText").value);
    if (document.getElementById("auto").value != null) {
        $('#randomTrueText').val(document.getElementById("auto").value);
    }
});

$('#userEncryptionKeyFile').change(function() {

    var $this_iv_file = $(this);
    var $clone = $this_iv_file.clone();
    $this_iv_file.attr('name', 'fileEncryptionKeyFile');
    $this_iv_file.attr('id', 'fileEncryptionKeyFile');
    $this_iv_file.attr('style', 'display: none;');
    $this_iv_file.after($clone).appendTo('#enc_file_area');

    var $this_enc_text = $(this),
        $clone = $this_enc_text.clone();
    $this_enc_text.attr('name', 'textEncryptionKeyFile');
    $this_enc_text.attr('style', 'display: none;');
    $this_enc_text.after($clone).appendTo('#enc_text_area');

});

$("#auto").change(function() {
    if ($(this).prop("checked") == true) {

        $(this).val("TRUE");
        if ($('#encInputFile').is(":visible")) {
            $('#encInputFile').attr('style', 'pointer-events:none');
            $('#encInputFile').attr('style', 'opacity:0.4');

        } else {
            $('#encInputText').attr('style', 'pointer-events:none');
            $('#encInputText').attr('style', 'opacity:0.4');
        }
    }

});

$("#manualFile").change(function() {
    if ($(this).prop("checked") == true) {

        $('#auto').val(null);

        $('#encInputFile').attr('style', 'pointer-events:auto');
        $('#encInputFile').attr('style', 'opacity:1.0');
        $('#encInputText').hide();
    }
});

$("#manualText").change(function() {
    if ($(this).prop("checked") == true) {
        $('#auto').val(null);
        $('#encInputText').attr('style', 'pointer-events:auto');
        $('#encInputText').attr('style', 'opacity:1.0');
        $('#encInputText').show();
        $('#encInputFile').hide();
    }
});
