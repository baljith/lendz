var msg_container = "#msg_container";
var msg_class = ".msg_no"; //IT should Contain Dat-id(Msg_Id)
var User_Id = "#User_Id";
var previous_btn = "#load_previous_msg_button";
var interval = "";
var jqxhr = {
    abort: function() {}
};
$(document).ready(function()
{
    $(previous_btn).click(function()
    {
        min = get_min(msg_class);
        get_messages(min);
    });
    $('#send_message_form').submit(function(e)
    {
        e.preventDefault();
        clearInterval(interval);
        var forms = $('#send_message_form')[0]; // You need to use standard javascript object here
        var formData = new FormData(forms);
        formData.append('timestamp', $.now());
        $('#send_message_form')[0].reset();
        jqxhr.abort();
        $.ajax(
        {
            url: ajax_url + 'chat/send',
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            async: true,
            cache: false,
            contentType: false,
            success: function(data)
            {
                if (data['status'])
                {
                    // $('#send_message_form')[0].reset();
                    get_messages();
                }
                else
                {
                   // msg_div(data['status'], data['msg']);
                }
            }
        }).done(function()
        {
            $(".loader").addClass("hide");
            console.log("success");
        }).fail(function()
        {
            $(".loader").addClass("hide");
            console.log("error");
        }).always(function()
        {
            start();
        });
    });
    $('#show_archive').click(function()
    {
        if ($(this).children('a').hasClass('active_archieve'))
        {
            $(this).children('a').removeClass('active_archieve').text('Show Archive');
            $('#archive_input').val(0);
        }
        else
        {
            $(this).children('a').addClass('active_archieve').text('Hide Archive');
            $('#archive_input').val(1);
        }
        getData(0);
    });
});

function get_messages(min)
{
    min = min || "";
    var max = get_max(msg_class);
    var Send_To = $(User_Id).val();
    var thread_id = $('#thread_id').val();
    var thread_type = $('#thread_type').val();
    if($('#from_id').length>0)
    {
        var from_id = $('#from_id').val();
    }
    else
    {
         var from_id = "";
    }
    jqxhr = $.ajax(
    {
        url: ajax_url + 'chat/get_messages',
        type: 'POST',
        dataType: 'json',
        async: true,
        data:
        {
            Send_To: Send_To,
            Last_Id: max,
            Min_Id: min,
            thread_id: thread_id,
            thread_type: thread_type,
            from_id:from_id
        },
        success: function(data)
        {
            if (min != "")
            {
                if (data.data && data.data != '')
                {
                    $.each(data.data, function(d, v)
                    {
                        console.log(v.Date);
                        chek = already_exist(msg_class, v.M_Id);
                        if (chek == 'null')
                        {
                            append_data(v, 'prepend');
                        }
                    });
                }
                else
                {
                    $(previous_btn).hide();
                }
            }
            else if (max != null)
            {
                if (data.data != '')
                {
                    $.each(data.data, function(d, v)
                    {
                        chek = already_exist(msg_class, v.M_Id);
                        if (chek == 'null')
                        {
                            append_data(v, 'append');
                        }
                    });
                    $('#main_div').slimScroll(
                    {
                        scrollTo: $('#main_div')[0].scrollHeight
                    });
                }
            }
            else
            {
                $(msg_container).html('');
                if (data.data != '')
                {
                    $.each(data.data, function(d, v)
                    {
                        chek = already_exist(msg_class, v.M_Id);
                        if (chek == 'null')
                        {
                            append_data(v, 'prepend');
                        }
                    });
                    $('#main_div').slimScroll(
                    {
                        scrollTo: $('#main_div')[0].scrollHeight
                    });
                }
                else
                {
                    $(previous_btn).hide();
                }
            }
        }
    });
}

function already_exist(selector, value)
{
    max = value;
    yes = 'null';
    $(selector).each(function()
    {
        var id = parseInt($(this).data('id'), 10);
        if (isNaN(id))
        {
            return;
        }
        if ((max === null) || (id == max))
        {
            yes = 1;
        }
    });
    return [yes];
}

function get_max(msg_class)
{
    var max = null;
    $(msg_class).each(function()
    {
        var id = parseInt($(this).data('id'), 10);
        if (isNaN(id))
        {
            return;
        }
        if ((max === null) || (id > max))
        {
            max = id;
        }
    });
    return max;
}

function get_min(msg_class)
{
    var min = null;
    $(msg_class).each(function()
    {
        var id = parseInt($(this).data('id'), 10);
        if (isNaN(id))
        {
            return;
        }
        if ((min === null) || (id < min))
        {
            min = id;
        }
    });
    return min;
}
//Append data here 
function append_data(obj, type)
{
    text = '<li class="' + obj.class + ' msg_no" data-id="' + obj.M_Id + '">' + '<span class="date-time"><i class="fa fa-clock-o"></i> ' + get_date_format(obj.Date) + '</span>' + '<a href="javascript:;" class="name">' + obj.User_First_Name + ' ' + obj.User_Last_Name + '</a>' + '<a href="javascript:;" class="image">' + '<span class="first-letter">' + obj.User_First_Name.slice(0, 1) + '</span></a>' + '<div class="message">' + obj.Message + '</div>' + '</li>';
    if (type == 'append')
    {
        $(msg_container).append(text);
    }
    else
    {
        $(msg_container).prepend(text);
    }
}

function start()
{
    interval = setInterval(function test()
    {
        get_messages();
    }, 3000);
}

function archive_chat(msg, obj)
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
                    var id = $(obj).data('id');
                    var status = $(obj).data('status');
                    if (id != '')
                    {
                        $.post(ajax_url + 'chat/archive_chat',
                        {
                            'id': id,
                            'status': status,
                        }, function(data, textStatus, xhr)
                        {
                            msg_div(data.status, data.msg);
                            if (data.status)
                            {
                                $(obj).parents('.unread_msg').css(
                                {
                                    background: '#cacaca'
                                });
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