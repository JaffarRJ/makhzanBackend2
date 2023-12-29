// Get the CSRF token from the meta tag
var csrfToken = $('meta[name="csrf-token"]').attr('content');

function changeStatus(routeUrl, id, status) {
    new swal({
        title: "Are you sure?",
        text: "Are you sure you want to update this status?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: routeUrl,
                data: { '_token': csrfToken, is_active: status, id: id },
                type: "post",
                beforeSend: function() {
                    // setting a timeout
                    $(".page-loader-wrapper").css("display", "block");
                },
                success: function (response) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.success('Status updated successfully', {timeOut: 3000});
                    $(".page-loader-wrapper").css("display", "none");
                    location.reload();

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
