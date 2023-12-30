$("form[name='roleForm']").validate({
    // Define validation rules
    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 30,
        },
    },
    // Specify validation error messages
    messages: {
        name: {
            required: "Please provide a valid name.",
            maxlength: "Name should not be greater than 10 characters.",
            minlength: "Name should be at least 3 characters",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
$(":input").inputmask();
