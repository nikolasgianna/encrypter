$("#textUpload").on("submit", function(e) {
    if (document.getElementById("auto").value != null) {
        $('#randomEncryptionKey').val(document.getElementById("auto").value);
    }
});

$("#fileToUpload").on("submit", function(e) {
    if (document.getElementById("auto").value != null) {
        $('#randomEncryptionKey').val(document.getElementById("auto").value);
    }
});

$("#SHA").change(function() {
    if ($(this).prop("checked") == true) {

        if ($('#encInputFile').is(":visible")) {
            $('#encInputFile').attr('style', 'pointer-events:none');
            $('#encInputFile').attr('style', 'opacity:0.4');
        } else {
            $('#encInputText').attr('style', 'pointer-events:none');
            $('#encInputText').attr('style', 'opacity:0.4');
        }
        $('#options').attr('style', 'pointer-events:none');
        $('#options').attr('disabled', 'disabled');
        $('#options').attr('style', 'opacity:0.4');
    }

});

$("#AES").change(function() {
    if ($(this).prop("checked") == true) {

        if ($('#encInputFile').is(":visible")) {
          if ($('#auto').prop("checked") != true) {
            $('#encInputFile').attr('style', 'pointer-events:auto');
            $('#encInputFile').attr('style', 'opacity:1.0');
          }
        } else {
          if ($('#auto').prop("checked") != true) {

            $('#encInputText').attr('style', 'pointer-events:auto');
            $('#encInputText').attr('style', 'opacity:1.0');
          }
        }
        $('#options').attr('style', 'pointer-events:auto');
        $('#options').removeAttr('disabled');
        $('#options').attr('style', 'opacity:1.0');
    }
});

$("#RSA").change(function() {
    if ($(this).prop("checked") == true) {
      if ($('#encInputFile').is(":visible")) {
        if ($('#auto').prop("checked") != true) {
          $('#encInputFile').attr('style', 'pointer-events:auto');
          $('#encInputFile').attr('style', 'opacity:1.0');
        }
      } else {
        if ($('#auto').prop("checked") != true) {

          $('#encInputText').attr('style', 'pointer-events:auto');
          $('#encInputText').attr('style', 'opacity:1.0');
        }
      }
      $('#options').attr('style', 'pointer-events:auto');
      $('#options').removeAttr('disabled');
      $('#options').attr('style', 'opacity:1.0');
    }
});

$("#auto").change(function() {
    if ($(this).prop("checked") == true) {

        $(this).val("auto");
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
