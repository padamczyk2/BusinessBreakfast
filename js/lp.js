$(document).ready(function () {
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function isName(name) {
        var regex = /^[a-zA-Z]{3,16}$/;
        return regex.test(name);
    }

    $("#modal-content").hide();
    $("#modal").hide();
    //$('.subscribe').prop('disabled', true);
    $(".subscribe").click(function () {
        $.ajax({
            type: "GET",
            url: 'https://spotkanie-biznesowe.cloud/mail.php',
            data: {
                'firstname': $('#firstname').val(),
                'lastname': $('#lastname').val(),
                'email': $('#email').val(),
                'phone': $('#phone').val(),
                'position': $('#position').val()
            },
            contentType: 'application/json',
            dataType: 'text',
            success: function (result) {
                alert("Na adres " + $('#email').val() + " wysłaliśmy wiadomość z prośbą o jego potwierdzenie");
                fieldsClear();
                //$("#modal-content").show();
                //$("#modal").show();
            },
            error: function (result) {
                alert("Na adres " + $('#email').val() + " wysłaliśmy wiadomość z prośbą o jego potwierdzenie");
                fieldsClear();
                //$("#modal-content").show();
                //$("#modal").show();
            },
        })
    });

    $(".inputes").change(function () {
            if ($("#agree1").is(':checked') && $("#agree2").is(':checked') && isName($("#firstname").val()) && isName($("#lastname").val()) && isEmail($("#email").val())) {
                $('.subscribe').prop('disabled', false);
            } else {
                $('.subscribe').prop('disabled', true);
            }
        }
    );

    $("#email").change(function () {
        if (isEmail($("#email").val())) {
            $("#email").css("border-color", "#b2b2b2");
        } else {
            $("#email").css("border-color", "red");
        }
    });

    $("#firstname").on("blur", function () {
        if (isName($(this).val())) {
            $("#firstname").css("border-color", "#b2b2b2");
        } else {
            $("#firstname").css("border-color", "red");
        }
    });

    $("#lastname").on("blur", function () {
        if (isName($(this).val())) {
            $("#lastname").css("border-color", "#b2b2b2");
        } else {
            $("#lastname").css("border-color", "red");
        }
    });

    $("#thanks-modal").click(function () {
        $('#firstname').val("");
        $('#lastname').val("");
        $('#email').val("");
        $("#modal-content").hide();
        $("#modal").hide();
    });

    function fieldsClear() {
        $('#firstname').val("");
        $('#lastname').val("");
        $('#email').val("");
        $('#phone').val("");
        $('#position').val("");
    }
});