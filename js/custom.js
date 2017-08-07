var dynamicElements = {
    spinner: '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
    spinnerOutgoing: '<div class="spinner spinner-outgoing"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>',
    alertSuccess: '<div class="alert alert-success text-center" id="alertSuccess" role="alert">Сообщение отправлено!</div>',
    btnClose: '<button type="button" class="btn btn-success" data-dismiss="modal" id="close">Закрыть</button>',
    msgInfo: '<tr class="info"><td colspan="4"><h4 class="text-center">Архив полученных писем пуст :(</h4></td></tr>'
};

$(document).ready(function () {
    $('button#refresh').click(function () {
        $(this).hide();
        $('#content_incoming').block({
            message: '<h4>Получаем письма...</h4>'
        });
        $('#buttons-group').append(dynamicElements.spinner);

        $.ajax({
            url: "resources/imap-fetch-insert.php",
            type: "POST",
            success: function () {
                $('.spinner').remove();
                $('button#refresh').show();
                loadTableIncoming();
            }
        });

    });
    $('#btn_nav_incoming').click(function (e) {
        e.preventDefault();
        $('#btn_nav_outgoing').closest('li').removeClass('active');
        $(this).closest('li').addClass('active');
        $('button#refresh').show();
        loadTableIncoming();
    });
    $('#btn_nav_outgoing').click(function (e) {
        e.preventDefault();
        $('#btn_nav_incoming').closest('li').removeClass('active');
        $(this).closest('li').addClass('active');
        $('button#refresh').hide();
        loadTableOutgoing();
    });

    dynamicTriggers();

    $('form#delete').on('submit', function () {
        var url = $(this).attr('action'),
            type = $(this).attr('method'),
            checkboxes_inc = $('#table_incoming td input:checkbox:checked'),
            checkboxes_out = $('#table_outgoing td input:checkbox:checked'),
            dataIncoming = [],
            dataOutgoing = [];

        if (checkboxes_inc.length) {
            $('button#refresh').hide();
            $('#buttons-group').append(dynamicElements.spinner);
            $('#content_incoming').block({
                message: '<h4>Удаляем письма...</h4>'
            });
            checkboxes_inc.each(function () {
                dataIncoming.push($(this).val());
            });

            $.ajax({
                url: url,
                type: type,
                data: {msgToDelIncoming: dataIncoming},
                success: function (response) {
                    try {
                        var resp = JSON.parse(response);
                        console.log('Status: ' + resp.status);
                    } catch (e) {
                        console.log('Error: ' + e.name + ': ' + e.message)
                    }
                    if (resp.status === 'ok') {
                        resp.uidsToDel.forEach(function (uid) {
                            $('#row-' + uid).fadeOut(500);
                            setTimeout(function () {
                                $('#row-' + uid).remove();
                            }, 600);
                        })
                    }

                    if ($('[id^="row-"]'.length < 0)) {
                        loadTableIncoming();
                    }
                    $('.spinner').remove();
                    $('button#refresh').show();
                    $('#content_incoming').unblock();
                }
            });
        } else if (checkboxes_out.length) {
            checkboxes_out.each(function () {
                dataOutgoing.push($(this).val());
            });

                $.ajax({
                    url: url,
                    type: type,
                    data: {msgToDelOutgoing: dataOutgoing},
                    success: function (response) {
                        try {
                            var resp = JSON.parse(response);
                            console.log('Status: ' + resp.status);
                        } catch (e) {
                            console.log('Error: ' + e.name + ': ' + e.message)
                        }
                        if (resp.status === 'ok') {
                            resp.idsToDel.forEach(function (id) {
                                $('#row-' + id).fadeOut(500);
                                setTimeout(function () {
                                    $('#row-' + id).remove();
                                }, 600);
                            })
                        }
                        if ($('[id^="row-"]'.length < 0)) {
                            loadTableOutgoing();
                        }
                    }
                });
        } else {
            $('button#btn_delete').popover({
                content: 'Вы забыли отметить сообщения :)',
                placement: 'top',
                trigger: 'focus'
            }).popover('show').one('hidden.bs.popover', function () {
                $(this).popover('destroy');
            })
        }
        return false;
    });

    $('form#create_msg').on('submit', function () {
        var url = $(this).attr('action'),
            type = $(this).attr('method'),
            data = $(this).serializeArray();

        $(this).find('input, textarea').attr('readonly', true);
        if (!$('input#destination').hasClass('has-error')) {
            $('button#send, button#cancel').hide();
            $('.modal-footer').append(dynamicElements.spinnerOutgoing);
        }
        $('.has-error').removeClass('has-error');

        console.log('Serialized array:\n');
        console.log(data);

        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function (response) {
                try {
                    var resp = JSON.parse(response);
                    console.log('Status: ' + resp.status);
                } catch (e) {
                    console.log('Error: ' + e.name + ': ' + e.message)
                }

                if (resp.hasOwnProperty('errors')) {
                    if (resp.errors.hasOwnProperty('destination')) {
                        form_warning('Введен некорректный Email');
                    } else if (resp.errors.hasOwnProperty('destination_empty')) {
                        form_warning('Вы забыли указать Email :)');
                    }
                } else { // if errors not detected
                    $('.spinner').remove();
                    $('.modal-footer').append(dynamicElements.alertSuccess, dynamicElements.btnClose).hide().fadeIn("slow");
                    $('.modal#create_msg').on('hidden.bs.modal', function () {
                        $('#btn_nav_outgoing').trigger("click");
                    });
                }
            },
            error: function (error) {
                console.log("Error: " + error);
            }
        });
        return false;
    });

    $('.modal#create_msg').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('button#send, button#cancel').show();
        $('form#create_msg').find('input, textarea').removeAttr('readonly');
        $('#alertSuccess, button#close').remove();
        $('input#destination').popover('destroy');
        $('.has-error').removeClass('has-error');
    });
});

function dynamicTriggers() {
    $('input#selectAll').click(function () {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });

    $('td[data-target="#view_msg"]').click(function () {
        var currentMsgId = $(this).closest('tr').find('input').val();

        if ($(this).closest('table').is('#table_outgoing')) {
            $.ajax({
                url: "resources/form-view-msg-out.php",
                type: "POST",
                data: {CurrentMsgIdOut: currentMsgId},
                success: function (response) {
                    $('#table_outgoing tbody').append(response);
                    $('.modal#view_msg').modal('show').on('hidden.bs.modal', function () {
                        $(this).remove();
                    });
                },
                error: function (error) {
                    console.log("Error: " + error);
                }
            });
        } else if ($(this).closest('table').is('#table_incoming')) {
            $.ajax({
                url: "resources/form-view-msg-inc.php",
                type: "POST",
                data: {CurrentMsgIdInc: currentMsgId},
                success: function (response) {
                    $('#table_incoming tbody').append(response);
                    $('.modal#view_msg').modal('show').on('hidden.bs.modal', function () {
                        $(this).remove();
                    });
                },
                error: function (error) {
                    console.log("Error: " + error);
                }
            });
        }

    });

    Sortable.init();
}

function form_warning(msg) {
    $('.spinner').remove();
    $('button#send, button#cancel').show();
    $('form#create_msg').find('input, textarea').removeAttr('readonly');
    $('#destination_form').addClass('has-error');

    setTimeout(function () {
        $('input#destination').popover({
            content: msg,
            placement: 'top',
            trigger: 'manual'
        }).popover('show');
    }, 200);
    $('input#destination, button#send').click(function () {
        $('input#destination').popover('destroy');
        $('.has-error').removeClass('has-error');
        $(this).unbind('click');
    });
}

function loadTableIncoming() {
    $('#main_content').load('resources/table-incoming.php', function () {
        dynamicTriggers();
    }).hide().fadeIn(500);
}

function loadTableOutgoing() {
    $('#main_content').load('resources/table-outgoing.php', function () {
        dynamicTriggers();
    }).hide().fadeIn(500);
}