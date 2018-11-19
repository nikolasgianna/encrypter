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

    function getValEnc(sel) {
        switch (sel.value) {
            case 'text':
                $('#encInputText').show();
                $('#encInputFile').hide();
                break;
            case 'file':
                $('#encInputText').hide();
                $('#encInputFile').show();
                break;
        }
    }

    function getValIv(sel) {
        switch (sel.value) {
            case 'text':
                $('#IvInputText').show();
                $('#IvInputFile').hide();
                break;
            case 'file':
                $('#IvInputText').hide();
                $('#IvInputFile').show();
                break;
        }
    }
