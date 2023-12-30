$("form[name='permissionForm']").validate({
    // Define validation rules
    rules: {
        name: {
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        tab_name: {
            required: true,
            minlength: 3,
            maxlength: 30,
        },
        route: {
            required: true,
            minlength: 3,
            maxlength: 30,
        },
    },
    // Specify validation error messages
    messages: {
        name: {
            required: "Please provide a valid name.",
            maxlength: "Name should not be greater than 30 characters.",
            minlength: "Name should be at least 3 characters",
        },
        tab_name: {
            required: "Please provide a valid name.",
            maxlength: "Tab Name should not be greater than 30 characters.",
            minlength: "Tab Name should be at least 3 characters",
        },
        route: {
            required: "Please provide a valid name.",
            maxlength: "Route should not be greater than 30 characters.",
            minlength: "Route should be at least 3 characters",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
$(":input").inputmask();
