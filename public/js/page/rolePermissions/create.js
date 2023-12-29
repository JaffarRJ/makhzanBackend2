$("form[name='addform']").validate({
    // Define validation rules
    rules: {
        role_id: {
            required: true,
        },
        permission_id: {
            required: true,
        },
    },
    // Specify validation error messages
    messages: {
        role_id: {
            required: "Please select Role.",
        },
        permission_id: {
            required: "Please Select Permission.",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
