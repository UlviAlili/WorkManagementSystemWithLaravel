<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function () {
        $('.text1').summernote(
            {
                'height': 60,
                inheritPlaceholder: true
            }
        );
    });
</script>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>
    $('#orders1, #orders2 , #orders3').sortable({
        connectWith: '#orders1, #orders2 , #orders3',
        opacity: 0.5,
        cursor: 'grabbing',
        update: function () {
            let order1 = $('#orders1').sortable('serialize');
            let order2 = $('#orders2').sortable('serialize');
            let order3 = $('#orders3').sortable('serialize');
            // console.log(order1)
            $.ajax({
                method: 'post',
                url: '{{route('user.task.sortable',$project->id)}}',
                data: {order1, order2, order3, _token: '{{csrf_token()}}'},
            });
        }
    });

    let b = {!! json_encode($project->tasks()->get()) !!};
    for (let i = 0; i < b.length; i++) {
        let a = b[i].id

        //When Modal Open can't be sortable task card
        $("#taskModal_" + a).on('shown.bs.modal', function () {
            $('#orders1, #orders2 , #orders3').sortable({
                disabled: true
            });
        });

        //When Modal Hide can be sortable task card
        $("#taskModal_" + a).on('hidden.bs.modal', function () {
            $('#orders1, #orders2 , #orders3').sortable({
                disabled: false
            });
        });
    }

    $(function () {
        $('#FrmCreateTask').submit(function (e) {
            e.preventDefault();
            $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#mySubmit').prop('disabled', true);
            let myData = $(this).serialize();
            $.ajax({
                method: 'post',
                url: '{{route('user.task.create')}}',
                data: myData,
                success: function (response) {
                    $('.myLoad').html('');
                    $('#mySubmit').prop('disabled', false);
                    window.location.href = response.url;

                    // $('.modal').modal('hide')
                    // $('.modal').on('hidden.bs.modal', function () {
                    //     $(this).find('form').trigger('reset');
                    // })
                    //
                    // toastr.options =
                    //     {
                    //         "closeButton": true,
                    //         "progressBar": true
                    //     }
                    // toastr.success(response.message);
                    //
                    // $('.AddTask').append(response.view);
                },
                error: function (response) {
                    $('#FrmCreateTask').find('.text-danger').remove();
                    $('.myLoad').html('');
                    $('#mySubmit').prop('disabled', false);
                    $.each(response.responseJSON.errors, function (key, value) {
                        let input = $('#FrmCreateTask').find('input[name^=' + key + ']');
                        input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                    });
                }
            });
        });
    });

    $(function () {
        $('.FrmUpdateTask').submit(function (e) {
            e.preventDefault();
            $('.myLoad').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.mySubmit').prop('disabled', true);
            let useUrl = $(this).data('url');
            let myData = $(this).serialize();
            $.ajax({
                method: 'put',
                url: useUrl,
                data: myData,
                success: function (response) {
                    $('.myLoad').html('');
                    $('.mySubmit').prop('disabled', false);
                    $('.modal').modal('hide')
                    window.location.href = response.url;
                },
                error: function (response) {
                    $('.FrmUpdateTask').find('.text-danger').remove();
                    $('.myLoad').html('');
                    $('.mySubmit').prop('disabled', false);
                    $.each(response.responseJSON.errors, function (key, value) {
                        let input = $('.FrmUpdateTask').find('input[name^=' + key + ']');
                        let input2 = $('.FrmUpdateTask').find('textarea[name^=' + key + ']');
                        input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                        input2.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                    });
                }
            });
        });
    });

    $(function () {
        $(document).on('submit', '.FrmDeleteTask', function (e) {
            e.preventDefault();
            let userUrl = $(this).data('url');
            let parentTr = $(this).parent().parent().parent().closest('div');
            if (confirm("Do you want to remove this task?")) {
                $.ajax({
                    url: userUrl,
                    type: 'DELETE',
                    data: {_token: '{{csrf_token()}}'},
                    success: function (response) {
                        console.log('success');
                        // window.location.reload();
                        toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true
                            }
                        toastr.success(response.message);
                        parentTr.remove();
                    },
                });
            }
        });
    });

    $('.FrmComment').submit(function (e) {
        e.preventDefault();
        $('.myLoad1').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $('.mySubmit1').prop('disabled', true);
        let useUrl = $(this).data('url');
        let myData = $(this).serialize();
        console.log(myData)
        $.ajax({
            method: 'post',
            url: useUrl,
            data: myData,
            success: function (response) {
                $('.myLoad1').html('');
                $('.mySubmit1').prop('disabled', false);
                window.location.href = response.url;
            },
            error: function (response) {
                $('.FrmComment').find('.text-danger').remove();
                $('.myLoad1').html('');
                $('.mySubmit1').prop('disabled', false);
                $.each(response.responseJSON.errors, function (key, value) {
                    let input = $('.FrmComment').find('textarea[name^=' + key + ']');
                    input.parents('.form-group').append(`<small class="row text-danger ml-1">${value}</small>`);
                });
            }
        });
    })
</script>
