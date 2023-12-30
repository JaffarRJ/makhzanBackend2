$("form[name='partyTransaction']").validate({
    // Define validation rules
    rules: {
        party_id: {
            required: true,
        },
        transaction_id: {
            required: true,
        },
    },
    // Specify validation error messages
    messages: {
        party_id: {
            required: "Please select Party.",
        },
        transaction_id: {
            required: "Please check transaction.",
        },
    },
    submitHandler: function (form) {
        form.submit();
    },
});
