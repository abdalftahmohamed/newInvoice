<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('change', '.change_status', function () {

        var id = $(this).attr('{{$route_id}}');
        var url = "{{ route($route_name.'.status', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: 'GET',

            success: function (response) {
                if (response.status == 'success') {
                    // $('.tostar_success').text(response.message).show();
                    // change status
                    $('#status_' + response.data.id).empty();
                    $('#status_' + response.data.id).text(response.data.status_name);

                    // Show SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: "{{__('Success!')}}",
                        text: response.message,
                        timer: 2000, // Optional: Auto close after 2 seconds
                        showConfirmButton: false
                    });
                } else {
                    $('.tostar_error').show();
                    $('.tostar_error').text(response.data.message);
                }
                setTimeout(function () {
                    $('.tostar_success').hide();
                }, 5000);

            }

        });
    });
</script>
