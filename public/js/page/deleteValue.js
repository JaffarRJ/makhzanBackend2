// Get the CSRF token from the meta tag
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function deleteValue(deleteValue, id) {
    //  e.preventDefault();
    // var id = $(this).attr("data-id");
    new swal({
        title: "Are you sure?",
        text: "Are you sure you want to Delete this?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteValue,
                data: { id: id },
                type: "post",
                success: function (response) {
                    if(response.success == true) {
                        toastr.success('Deleted successfully', {timeOut: 3000});
                            location.reload();
                    }else{
                        toastr.error('Deleted creating an error', {timeOut: 3000});
                        location.reload();
                    }
                    // You will get response from your PHP page (what you echo or print)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
            });
        } else {
            location.reload();
        }
    });
}
