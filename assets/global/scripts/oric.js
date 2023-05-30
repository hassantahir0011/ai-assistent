


function RemoveTableRow(TableId, Row_selector) {
    var table = $('#' + TableId).DataTable();
    Row_selector.fadeOut(1000, function () {
        table
            .row($(Row_selector))
            .remove()
            .draw();
    });

}
function validate_dependant_fields(first_element_id,second_element_id){

    return (
        ($("#"+first_element_id).val() !="" &&  $("#"+second_element_id).val() !="")
        ||
        !($("#"+second_element_id).val() =="")
    );

    return (
        ($("#"+first_element_id).val() =="" && $("#"+second_element_id).val() == "")
        ||
        (($("#"+first_element_id).val() =="" || $("#"+first_element_id).val() == "\u200B")
            &&
            ($("#"+second_element_id).val() !="" || $("#"+second_element_id).val() == "\u200B"))
        ||
        (( $("#"+first_element_id).val() !="" && $("#"+first_element_id).val() != "\u200B")
            &&
            ($("#"+second_element_id).val() !=""  && $("#"+second_element_id).val() != "\u200B"))


    );
}

function oric_Validation_application(form_id, validate_rules_obj, validate_messages_obj,prevent_form_submit) {
    // for more info visit the official plugin documentation:
    // http://docs.jquery.com/Plugins/Validation
    var form1 = $('#' + form_id);
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);


    $.validator.addMethod("validpassword", function (value, element) {
        return this.optional(element) || /^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/.test(value);
    }, "Valid password:Upper case,Special character and a digit");

    $.validator.addMethod("zeroWideSpace", function(value, element) {
        return !(element.value == "\u200B");
    }, 'Invalid value entered.');

    //google contacts dependant fields
    $.validator.addMethod("gContactPhoneType", function(value, element) {
        return validate_dependant_fields("g_contact_phone_type","g_contact_phone_number");
    }, 'Phone number is mandatory if phone type given.');
    $.validator.addMethod("gContactPhoneNumber", function(value, element) {
        return validate_dependant_fields("g_contact_phone_number","g_contact_phone_type");
    }, 'Phone type is mandatory if phone number given.');



    //form validate method
    form1.validate({
        errorElement: 'div', //default input error message container
        errorClass: 'Polaris-Labelled__Error Polaris-InlineError', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: validate_rules_obj,
        messages: validate_messages_obj,
        invalidHandler: function (event, validator) { //display error alert on form submit
          //  success1.hide();
           // error1.show();
            window.scrollTo(error1, -200);
        },

        errorPlacement: function (error, element) {

            if (element.is('select')) {
                error.insertAfter(element.closest("div"));
            } else if(element.hasClass('hidden_rich_textarea')){
                error.insertBefore(element);
            }else{
                error.insertAfter(element.closest("div").parent().parent());
            }
                /*} else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }*/
        },

        highlight: function (element) { // hightlight error inputs
            $(element).addClass('has-error');

            $(element)
                .closest('.input-group label').addClass('btn-danger');

            $(element)
                .next('.input-group-btn').css({'top':'-12px'})
        },

        unhighlight: function (element) { // revert the change done by hightlight
            $(element).removeClass('has-error');
            $(element)
                .closest('.input-group label').removeClass('btn-danger');
            $(element)
                .next('.input-group-btn').css({'top':'-12px'})
        },

        success: function (label) {
            label
                .closest('.input-group,.form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function (form) {
            // success1.show();
            // error1.hide();
            if(!prevent_form_submit)
            form.submit();


        }
    });
}

//convert into float value
function parseFloatValues(value) {
    value = ((value == '' || value == undefined || value == NaN) ? 0 : value );
    value = parseFloat(value);
    return value;
}
function parseFloatValue(value) {
    value = ((value == '' || value == undefined || value == NaN) ? 0 : value );
    if (comma_exist(value))
        var value = value.replace(/\,/g, '');
    value = parseFloat(value);
    return value;
}
function comma_exist(sNumber) {
    var substring = ',';
    if (sNumber == '')
        return false;
    console.log(sNumber);
    if (sNumber.indexOf(substring) !== -1)
        return true;
    else
        return false;
}
jQuery(document.body).on('keyup','.validnumber', function () {
    this.value = this.value.replace(/[^0-9\.]/g, '');
});
