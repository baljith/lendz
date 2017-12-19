$(document).ready(function()
{
    if ($('#Package_Description').length > 0)
    {
        CKEDITOR.replace('Package_Description');
    }
    $('#add_package_form').validate(
    {
        ignore: [],
        rules:
        {
            Package_Description:
            {
                required: function()
                {
                    CKEDITOR.instances.Package_Description.updateElement();
                },
                minlength: 10
            }
        },
        submitHandler: function(form)
        {
            $.ajax(
            {
                url: ajax_url + 'packages/insert',
                type: 'POST',
                dataType: 'json',
                data: $(form).serialize(),
                success: function(data)
                {
                    msg_div(data.status, data.msg);
                    if (data.status)
                    {
                        $(form)[0].reset();
                    }
                },
            }).done(function()
            {
                console.log("success");
            }).fail(function()
            {
                console.log("error");
            }).always(function()
            {
                console.log("complete");
            });
        }
    });
});