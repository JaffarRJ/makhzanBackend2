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
        email: {
            required: true,
            validate_email: true,
        },
        cnic: {
            required: true,
            minlength: 15,
            maxlength: 15,
        },
        phone: {
            required: true,
            minlength: 5,
            maxlength: 20,
        },
        address: {
            required: true,
            minlength: 5,
            maxlength: 200,
        },
    },
    // Specify validation error messages
    messages: {
        name: {
            required: "Please provide a valid name.",
            maxlength: "Name should not be greater than 10 characters.",
            minlength: "Name should be at least 3 characters",
        },
        email: {
            required: "Please enter your email",
        },
        phone: {
            required: "Please enter phone",
            maxlength: "password should not be greater than 20 characters.",
            minlength: "password should be at least 5 characters",
        },
        address: {
            required: "Please enter Address",
            maxlength: "password should not be greater than 200 characters.",
            minlength: "password should be at least 5 characters",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
$(":input").inputmask();
