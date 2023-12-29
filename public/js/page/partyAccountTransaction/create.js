$("form[name='addform']").validate({
    // Define validation rules
    rules: {
        party_id: {
            required: true,
        },
        transaction_id : {
            required: true,
            minlength: 1,
        },
        account_id: {
            account_id: true,
            minlength: 1,
        },
        sub_account_id: {
            required: true,
            minlength: 1,
        },
        amount: {
            required: true,
            minlength: 1,
        },
        dr: {
            required: true,
            minlength: 1,
            maxlength: 20,
        },
    },
    // Specify validation error messages
    messages: {
        party_id: {
            required: "Please provide a valid Party Name.",
        },
        transaction_id: {
            required: "Please select a transaction.",
        },
        account_id: {
            required: "Please enter your Account",
        },
        sub_account_id: {
            required: "Please enter Sub Account",
        },
        amount: {
            required: "Please enter Amount",
        },
        transaction_type: {
            required: "Please Select Debit or Credit",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
