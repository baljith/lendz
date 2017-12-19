xhrPool = [];
$(document).ready(function()
{
    $('#data-table').DataTable({
        "order": []
    });

    
    jQuery.fn.forceNumeric = function()
    {
        return this.each(function()
        {
            $(this).keydown(function(e)
            {
                // this.value = this.value.replace(/[^0-9]+/g, '');
                // if (this.value < 1) this.value = '';
                var key = e.which || e.keyCode;
                if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                    // numbers   
                    key >= 48 && key <= 57 ||
                    // Numeric keypad
                    key >= 96 && key <= 105 ||
                    // Backspace and Tab and Enter
                    key == 8 || key == 9 || key == 13 ||
                    // left and right arrows
                    key == 37 || key == 39) return true;
                return false;
            });
        });
    }
    jQuery.fn.forcePrice = function()
    {
        return this.each(function()
        {
            $(this).keyup(function(e)
            {
                var valid = /^\d{0,20}(\.\d{0,2})?$/.test(this.value),
                    val = this.value;
                if (!valid)
                {
                    this.value = 1;
                }
            });
        });
    }
    $('.check_price').forcePrice();
    $('.selectpicker').selectpicker();
    $('.datepicker').datepicker();
    $(".default-daterange").daterangepicker(
    {
        opens: "right",
        format: "MM/DD/YYYY",
        separator: " to ",
        startDate: moment().subtract("days", 29),
        endDate: moment(),
        minDate: "01/01/2012",
        maxDate: "12/31/2018"
    }, function(e, t)
    {
        $(".default-daterange input").val(e.format("MMMM D, YYYY") + " - " + t.format("MMMM D, YYYY"))
    });
    $('.check_numeric').forceNumeric();
    $('.table').parent('div').css('overflow', 'auto');
    //Load notification messages here
    $('#load_notification_messages').on('click', function()
    {
        if ($(this).parent('li').hasClass('open'))
        {}
        else
        {
            $.each(xhrPool, function(idx, jqXHR)
            {
                jqXHR.abort();
            });
            $('#my_messages').html('<div class="cssload-container"> <div class="cssload-zenith" style="left: 36%; top: 36%;"></div></div>');
            $.post(ajax_url + 'chat/unread', function(data, textStatus, xhr)
            {
                $('#my_messages').html(data);
            });
        }
    });
    //Notifications counter here
    $('#load_notifications').on('click', function()
    {
        if ($(this).parent('li').hasClass('open'))
        {}
        else
        {
            $.each(xhrPool, function(idx, jqXHR)
            {
                jqXHR.abort();
            });
            $('#my_notifications').html('<div class="cssload-container"> <div class="cssload-zenith" style="left: 36%; top: 36%;"></div></div>');
            $.post(ajax_url + 'chat/unread_notification', function(data, textStatus, xhr)
            {
                $('#my_notifications').html(data);
            });
        }
    });
    notification_counter_ajax();
    run_notification_intr();
    //Autocomplete filter start here
    $('#individual_autocomplete').autocomplete(
    {
        source: function(req, response)
        {
            $('#audience_loader').show();
            $.ajax(
            {
                url: ajax_url + 'users/autocomplete',
                type: 'POST',
                data: req,
                dataType: 'json',
                success: function(data)
                {
                    response(data);
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui)
        {
            console.log(ui);
            if (ui.item.id != 0)
            {
                $('#user_id').val(ui.item.id);
                $(this).val(ui.item.label).attr('readonly', 'readonly');
            }
            //$(this).val('');
            return false;
        }
    });

    $('#individual_autocomplete').focus(function(){     
            console.log("alert");
            $('#individual_autocomplete').trigger('keydown');
        }).focusout(function(event) {
            $('#individual_autocomplete').trigger('keyup');
        });;

    //Another
    $('#search_message').autocomplete(
    {
        source: function(req, response)
        {
            $('#audience_loader').show();
            $.ajax(
            {
                url: ajax_url + 'users/autocomplete',
                type: 'POST',
                data: req,
                dataType: 'json',
                success: function(data)
                {
                    response(data);
                }
            });
        },
        autoFocus: true,
        minLength: 1,
        select: function(event, ui)
        {
            console.log(ui);
            if (ui.item.id != 0)
            {
                var new_text = ui.item.label.split('(');
                $(this).val($.trim(new_text[0]));
                getData(0);
            }
            //$(this).val('');
            return false;
        }
    });

    $('#individual_autocomplete').click(function(event)
    {
        $(this).val('').removeAttr('readonly');
    });
    //Create thread Functionality here
    $('#create_thread_here').validate(
    {
        ignore: [],
        rules:
        {
            subject:
            {
                required: true,
                maxlength: 100,
            },
            individual_autocomplete:
            {
                required: true
            },
            message:
            {
                required: true
            }
        },
        messages:
        {
            subject:
            {
                required: "Please enter a subject first",
                maxlength: "Subject cannot be greater than 100 characters"
            },
            individual_autocomplete:
            {
                required: "Please select a user",
            },
            message:
            {
                required: "Please enter  message",
            }
        },
        submitHandler: function(form)
        {
            // $('#create_thread_btn_submit').attr('disabled', 'disabled');
            $.ajax(
            {
                url: ajax_url + 'chat/create_thread',
                type: 'POST',
                dataType: 'json',
                data: $(form).serialize(),
                success: function(data)
                {
                    $('#create_thread_btn_submit').removeAttr('disabled');
                    msg_div(data.status, data.msg);
                    if (data.status)
                    {
                        $(form)[0].reset();
                        $('#individual_autocomplete').removeAttr('readonly');
                        $('#modal-alert').modal('hide');
                        getData(0);
                    }
                },
            });
        }
    });
});

function Get_Process(val)
{
    return $.ajax(
    {
        url: ajax_url + 'price/get_process?Master_Id=' + val,
        method: 'POST',
        dataType: 'json',
    });
};

function msg_div(status, msg)
{
    if (status)
    {
        $.gritter.add(
        {
            title: 'Success',
            text: msg,
            time: 2000,
            class_name: 'gritter-info gritter-success'
        });
    }
    else
    {
        $.gritter.add(
        {
            title: 'Error!',
            text: msg,
            time: 2000,
            class_name: 'gritter-info gritter-error'
        });
    }
}


function perm_delete(obj)
{
    var current = $(obj); 
    $.confirm(
    {
        title: 'Confirm!',
        content: current.data('msg'),
        buttons:
        {
            confirm:
            {
                keys: ['enter'],
                btnClass: 'btn-confirm',
                action: function()
                {
                    if (value != '')
                    {
                        var value = current.data('id');
                        var table_name = current.data('table');
                        var col_name = current.data('column');
                        var status = current.data("status");
                        var msg = current.data('msg');
                        $.post(ajax_url + 'packages/common_delete',
                        {
                            'id': value,
                            'table_name': table_name,
                            'col_name': col_name,
                            'status': status
                        }, function(data, textStatus, xhr)
                        {
                            msg_div(data.status, data.msg);
                            if (data.status)
                            {
                                if (status == '1')
                                {
                                    current.data("status","0");
                                    current.data("msg",msg.replace('deactivate', 'activate'));
                                    current.attr('title','Activate');
                                    current.html('<i class="fa fa-reply" aria-hidden="true">');
                                    current.removeClass('delete_btn').addClass('primary_btn');
                                }
                                else
                                {
                                    current.data("status","1");
                                    current.data("msg",msg.replace('activate', 'deactivate'));
                                    current.attr('title','Deactivate');
                                    current.html('<i class="fa fa-trash-o" aria-hidden="true">');
                                    current.removeClass('primary_btn').addClass('delete_btn');
                                }
                            }
                        });
                    }
                    else
                    {
                        msg_div(false, 'Invalid argument');
                    }
                },
            },
            cancel:
            {
                keys: ['esc'],
                btnClass: 'btn-cancel',
            }
        }
    });
}
//
function connect_user(msg, id, obj)
{
    $.confirm(
    {
        title: 'Confirm!',
        content: msg,
        buttons:
        {
            confirm:
            {
                keys: ['enter'],
                btnClass: 'btn-confirm',
                action: function()
                {
                    if (id != '')
                    {
                        $.post(ajax_url + 'users/conection_request',
                        {
                            'id': id,
                        }, function(data, textStatus, xhr)
                        {
                            msg_div(data.status, data.msg);
                            if (data.status)
                            {
                                $(obj).parents('.btn_three').html('<label class="label label-success">Request Sent</label>');
                                $(obj).remove();
                            }
                        });
                    }
                    else
                    {
                        msg_div(false, 'Invalid argument');
                    }
                },
            },
            cancel:
            {
                keys: ['esc'],
                btnClass: 'btn-cancel',
            }
        }
    });
}

function get_date_format(Date_value)
{
    return dateFormat(new Date(Date_value), "mmm dd, yyyy, h:MM TT");
}

function run_notification_intr()
{
    //Notification counter here
    // notification_counter = setInterval(function test()
    // {
    //     notification_counter_ajax();
    // }, 3000);
}

function notification_counter_ajax()
{
    $.ajax(
    {
        url: ajax_url + 'chat/messages_counter',
        type: 'POST',
        beforeSend: function(jqXHR)
        {
            xhrPool.push(jqXHR);
        },
        success: function(data)
        {
            if (data == 0)
            {
                $('.Messages_counter').text('').hide();
                if ($('.Notifications_counter2').length > 0)
                {
                    $('.Notifications_counter2').text('').hide();
                }
            }
            else
            {
                $('.Messages_counter').text(data).show();
                if ($('.Notifications_counter2').length > 0)
                {
                    $('.Notifications_counter2').text(data + ' New Messages').show();
                }
            }
        }
    });
    $.ajax(
    {
        url: ajax_url + 'chat/notifcation_counter',
        type: 'POST',
        beforeSend: function(jqXHR)
        {
            xhrPool.push(jqXHR);
        },
        success: function(data)
        {
            if (data == 0)
            {
                $('.Notifications_counter').text('').hide();
            }
            else
            {
                $('.Notifications_counter').text(data).show();
            }
        }
    });
}
//Change notificaation here
function accpet_or_reject_status(id, sta, obj)
{
    if (id != '')
    {
        $.ajax(
        {
            url: ajax_url + 'users/update_connected',
            type: 'POST',
            dataType: 'json',
            data:
            {
                connect_id: id,
                status: sta
            },
            success: function(data)
            {
                if (data.status)
                {
                    msg_div(data.status, data.msg);
                    $(obj).parents('.media-body').find('.notification-action').remove();
                }
                else
                {
                    msg_div(data.status, data.msg);
                }
            }
        });
    }
    else
    {
        msg_div(false, 'request not found');
    }
}

function update_notification(obj)
{
    $.post(ajax_url + 'users/update_notification',
    {
        N_Id: $(obj).data('id')
    }, function(data, textStatus, xhr)
    {
        /*optional stuff to do after success */
    });
}