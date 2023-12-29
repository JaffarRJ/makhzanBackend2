$("form[name='addform']").validate({
    // Define validation rules
    rules: {
        account_id: {
            required: true,
        },
        sub_account_id: {
            required: true,
        },
    },
    // Specify validation error messages
    messages: {
        account_id: {
            required: "Please select Account.",
        },
        sub_account_id: {
            required: "Please check Sub Account.",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
