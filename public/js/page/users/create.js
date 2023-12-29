jQuery.validator.addMethod(
    "validate_email",
    function (value, element) {
        if (
            /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(
                value
            )
        ) {
            return true;
        } else {
            return false;
        }
    },
    "Please enter a valid Email."
);
$("form[name='addform']").validate({
    // Define validation rules
    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        role_id : {
            required: true,
        },
        email: {
            required: true,
            validate_email: true,
        },
        password: {
            required: true,
            minlength: 8,
            maxlength: 15,
        },
        password_confirmation: {
            required: true,
            minlength: 5,
            maxlength: 20,
        },
    },
    // Specify validation error messages
    messages: {
        name: {
            required: "Please provide a valid name.",
            maxlength: "Name should not be greater than 10 characters.",
            minlength: "Name should be at least 3 characters",
        },
        role: {
            required: "Please select a role.",
        },
        email: {
            required: "Please enter your email",
        },
        password: {
            required: "Please enter password",
            maxlength: "password should not be greater than 20 characters.",
            minlength: "password should be at least 8 characters",
        },
        password_confirmation: {
            required: "Please enter confirmation password",
            equalTo: "Your confirmation password does not match with new password",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
$(":input").inputmask();
