<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- change status --}}
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
                    $('.tostar_success').text(response.message).show();
                    // change status
                    yajraTable.ajax.reload();
                } else {
                    $('.tostar_error').show();
                    $('.tostar_error').text(response.message);
                }
                setTimeout(function () {
                    $('.tostar_success').hide();
                }, 5000);
            }

        });
    });
</script>
