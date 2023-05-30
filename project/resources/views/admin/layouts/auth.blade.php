<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    <link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css', null, true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.css', null, true) }}" rel="stylesheet" type="text/css"/>

    <link href="{{ URL::asset('assets/pages/css/login.min.css', null, true) }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/pages/css/login-5.css', null, true) }}" rel="stylesheet" type="text/css"/>


</head>

<body class=" login">

@yield('content')

@include('admin.partials.footer_script')
<script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
        type="text/javascript"></script>

{{--<script src="{{ URL::asset('assets/pages/scripts/login-5.js') }}"--}}
        {{--type="text/javascript"></script>--}}
<script>
    function oric_Validation(form_id, validate_rules_obj, validate_messages_obj) {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        var form1 = $('#' + form_id);
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        {{--$.validator.addMethod("seedoutemail", function (value, element) {--}}
        {{--return this.optional(element) || /^.+@seedout.org$/.test(value);--}}
        {{--}, "Only @seedout.org email acceptable.");--}}

        $.validator.addMethod("seedoutvalidpassword", function (value, element) {
            return this.optional(element) || /^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/.test(value);
        }, "Valid password:Upper case,Special character and a digit");

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: validate_rules_obj,
            messages: validate_messages_obj,
            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();
                form.submit();
            }
        });
    }

    $('button[type="submit"]').on('click', function () {
        //$('div.flash').hide('!important');
    });
</script>
@yield('last_scripts')

</body>
</html>


