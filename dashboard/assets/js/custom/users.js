$(document).ready(function()
{

    $(".profile_upload").click(function()
    {
        $(".profile_pic_cls").trigger("click");
    });
    var form = $("#User_Edit");
    form.validate(
    {
        ignore: [],
        submitHandler: function()
        {
            var forms = $('#User_Edit')[0]; // You need to use standard javascript object here
            var formData = new FormData(forms);
            $.ajax(
            {
                url: ajax_url + 'users/update_profile',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                success: function(data)
                {
                    $("html, body").animate(
                    {
                        scrollTop: 0
                    }, "slow");
                    if (data['status'])
                    {
                        msg_div(data['status'], data['msg']);
                    }
                    else
                    {
                        msg_div(data['status'], data['msg']);
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
                $(".loader").addClass("hide");
                console.log("complete");
            });
        }
    });
    $("#profile_pic").change(function()
    {
        if ($("#profile_pic").valid() == true)
        {
            readURL(this);
        }
    });
    $('.selectpicker').selectpicker(
    {
       liveSearch:true,
        size: 6,
        style: 'btn-cutsom-select',
    });
});

function readURL(input)
{
    if (input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function(e)
        {
            $('.profile_img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}