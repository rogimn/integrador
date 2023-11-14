/*jslint browser: true*/
/*jslint node: true*/
/*jslint browser: true*/
/*jslint es6*/
/*global $, jQuery, alert, btoa*/

$(document).ready(function () {
    'use strict';

    const fade = 150,
    Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    }),
    swalButton = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: true
    });

    // TOOLTIP GLOBAL

    $('[data-toggle="tooltip"], .td-action span a, .blockquote-data p a, div a, td span a, span a').tooltip({
        boundary: 'window'
    });

    // BACK UP

    $('.navbar-nav').on('click', '.a-make-bkp', function(e) {
        e.preventDefault();

        swalButton.fire({
            icon: 'question',
            title: 'Executar a c&oacute;pia de seguran&ccedil;a',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
        }).then(result0 => {
            if(result0.value == true) {
                $.ajax({
                    type: 'GET',
                    url: 'backup',
                    dataType: 'JSON',
                    cache: false,
                    beforeSend: () => {
                        $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                    },
                    error: result1 => {
                        if (result1.responseText) {
                            Swal.fire({
                                icon: 'error',
                                html: result1.responseText,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: 'Verifique se o servidor est&aacute; operacional.',
                                showConfirmButton: false
                            });
        
                            $('.div-load-page').addClass('d-none');
                        }
                    },
                    success: data => {
                        switch (data) {
                            case true:
                                Toast.fire({
                                    icon: 'success',
                                    title: 'C&oacute;pia de seguran&ccedil;a realizada com sucesso.'
                                });
        
                                $('.div-load-page').addClass('d-none');
                                $('.tooltip').removeClass('show').addClass('hide');
                                break;
        
                            default:
                                console.log(typeof(data));
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }
                    }
                });
            }
        });
    });

    // LOGOUT

    $('.navbar-nav').on('click', '.a-logout-app', function(e) {
        e.preventDefault();
        
        swalButton.fire({
            icon: 'question',
            title: 'Sair do App',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
        }).then((result) => {
            if(result.value == true) {
                location.href = 'sair';
            }
        });
    });

    /*// SEARCH

    $('.form-search').on('click', function () {
        $('.page-search').fadeIn(fade);
        $('.div-search-close').fadeIn(fade);
    });

    $('.icon-search-close').on('click', function () {
        $('.page-search').fadeOut(fade);
        $('#search_keyword').val('');
        $('#search-result').empty();
        $('.div-search-close').fadeOut(fade);
    });

    $('#search_keyword').keyup(function () {
        let value = $('#search_keyword').val(),
            minlength = 4;

        if (value.length >= minlength) {
            $.ajax({
                type: 'GET',
                url: 'api/servico/search.php',
                data: {'search_keyword': value},
                dataType: 'text',
                cache: false,
                beforeSend: function () {
                    $('#search-result').empty().append('<p style="position: relative;top: 15px;" class="lead"><i class="fas fa-cog fa-spin"></i> Processando...</p>');
                },
                success: function (data) {
                    //we need to check if the value is the same
                    if (value === $('#search_keyword').val()) {
                        $('#search-result').html(data);
                    }
                }
            });
        }

        if ($('#search_keyword').val() === '') {
            $('#search-result').empty();
        }
    });*/
});