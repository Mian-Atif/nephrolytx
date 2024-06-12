
jQuery(document).ready(function ($) {

    $('input[name="datefilter"]').daterangepicker({
            // autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $('input[name="dateStartfilter"]').val(picker.startDate.format('MM/DD/YYYY') );
            $('input[name="dateEndfilter"]').val(picker.endDate.format('MM/DD/YYYY') );
            // $('#formDatePicker').submit();
            var $f = $('#formDatePicker');
            var interval = setInterval(function() { NProgress.inc(); }, 1000);

            $.ajax({
                beforeSend: function () {
                    NProgress.set(0.4);
                },
                url: $f.attr('action'),
                type: $f.attr('method'),
                data: $f.serialize(),
                dataType: 'JSON',
                success: function (data) {
                    if (data.status) {
                        $('.table-body').replaceWith(data.view);
                        NProgress.done();
                        clearInterval(interval);
                    } /*else {

                        $sb.html(oldBtnText).prop('disabled', false);
                        new Noty({
                            type: 'error',
                            text: data.message
                        }).show();
                    }*/
                },
                error: function (xhr) {
                    loadRequestErrors(xhr);
                }
            });

        });

        function loadRequestErrors(xhr) {
            if (xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function (key, item) {
                    new Noty({
                        type: 'error',
                        text: item
                    }).show();
                });
            } else if (xhr.responseJSON.message) {
                new Noty({
                    type: 'error',
                    text: xhr.responseJSON.message
                }).show();
            }
            // $sb.html(oldBtnText).prop('disabled', false);
        }
        $('#searchFilter').submit(function (e) {
            e.preventDefault();
            var $f = $(this);
            var interval = setInterval(function() { NProgress.inc(); }, 1000);

            $.ajax({
                beforeSend: function () {
                    NProgress.set(0.4);
                },
                url: $f.attr('action'),
                type: $f.attr('method'),
                data: $f.serialize(),
                dataType: 'JSON',
                success: function (data) {
                    if (data.status) {
                        $('.table-body').replaceWith(data.view);
                        NProgress.done();
                        clearInterval(interval);
                    } else {
                        clearInterval(interval);

                        // $sb.html(oldBtnText).prop('disabled', false);
                        new Noty({
                            type: 'error',
                            text: data.message
                        }).show();
                    }
                },
                error: function (xhr) {
                    loadRequestErrors(xhr);
                }
            });


        });
        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
