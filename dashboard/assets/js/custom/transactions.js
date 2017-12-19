xhrPool = [];
$(document).ready(function()
{
    userDataTable = $('#user_datatable').DataTable(
    {
        "processing": true,
        "scrollX": true,
        "autoWidth": false,
        "serverSide": true,
        "order": [],
        "ajax":
        {
            url: ajax_url + "transactions/fetch_transactions",
            type: "POST",
            dataType: 'json',
            data: function(d) {},
        },
        
        "aoColumnDefs": [
        {
            "bSortable": false,
            "aTargets": ["no-sort"]
        }],
    });
});


//Cancel Subscription
function cancel_subs(msg,id, obj)
{
    msgs = msg.replace(/_/g, ' ');
    $.confirm(
    {
        title: 'Confirm!',
        content: msgs,
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
                        $.post(ajax_url + 'transactions/cancel_subs',
                        {
                            'id': id,
                        }, function(data, textStatus, xhr)
                        {
                            msg_div(data.status, data.msg);
                            if (data.status)
                            {
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
