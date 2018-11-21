    $("#fileUpload").on("submit", function(e) {
        $('#fileEncryptionKeyText').val(document.getElementById("userEncryptionKeyText").value);
        $('#fileIVText').val(document.getElementById("userIVText").value);
    });

    $("#textUpload").on("submit", function(e) {
        $('#textEncryptionKeyText').val(document.getElementById("userEncryptionKeyText").value);
        $('#textIVText').val(document.getElementById("userIVText").value);
    });

    $('#userEncryptionKeyFile').change(function() {

        var $this_enc_file = $(this),
            $clone = $this_enc_file.clone();
        $this_enc_file.attr('name', 'fileEncryptionKeyFile');
        $this_enc_file.attr('style', 'display: none;');
        $this_enc_file.after($clone).appendTo('#enc_file_area');

        var $this_enc_text = $(this),
            $clone = $this_enc_text.clone();
        $this_enc_text.attr('name', 'textEncryptionKeyFile');
        $this_enc_text.attr('style', 'display: none;');
        $this_enc_text.after($clone).appendTo('#enc_text_area');
    });

    $('#userIVFile').change(function() {

        var $this_iv_file = $(this);
        var $clone = $this_iv_file.clone();
        $this_iv_file.attr('name', 'fileIVFile');
        $this_iv_file.attr('id', 'fileIVFile');
        $this_iv_file.attr('style', 'display: none;');
        $this_iv_file.after($clone).appendTo('#iv_file_area');

        var $this_iv_text = $(this);
        var $clone = $this_iv_text.clone();
        $this_iv_text.attr('name', 'textIVFile');
        $this_iv_text.attr('id', 'textIVFile');
        $this_iv_text.attr('style', 'display: none;');
        $this_iv_text.after($clone).appendTo('#iv_text_area');

    });

    $("#encFile").change(function() {
        if ($(this).prop("checked") == true) {

            $('#encInputText').hide();
            $('#encInputFile').show();
        }
    });

    $("#encText").change(function() {
        if ($(this).prop("checked") == true) {
            $('#encInputText').show();
            $('#encInputFile').hide();
        }
    });

    $("#IVFile").change(function() {
        if ($(this).prop("checked") == true) {

            $('#IvInputText').hide();
            $('#IvInputFile').show();
        }
    });

    $("#IVText").change(function() {
        if ($(this).prop("checked") == true) {
            $('#IvInputText').show();
            $('#IvInputFile').hide();
        }
    });
