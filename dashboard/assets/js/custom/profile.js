var imageLoader = document.getElementById('profile_pic');
imageLoader.addEventListener('change', readURL, false);
$(document).ready(function()
{
    $("#profile_pic").change(function()
    {
        if ($("#profile_pic").valid() == true)
        {
            readURL(this);
        }
    });
    $('.selectpicker').selectpicker().change(function()
    {
        $(this).valid()
    });
    $('.selectpicker').change(function()
    {
        $(this).valid();
    })
    $(".profile_upload").click(function()
    {
        $(".profile_pic_cls").trigger("click");
    });
    $('#Current_Password').on('keyup',function(){
        if($(this).val()!='')
        {
            $('#New_Password').addClass('required');
        }
        else
        {
            $('#New_Password').removeClass('required');
        }
    });
    var form = $("#register_validate_form");
    form.validate(
    {
        rules:
        {
            Confirm_Password:
            {
              equalTo: "#New_Password"
            }
        },
        submitHandler: function()
        {
            $(".loader").removeClass("hide");
            var forms = $('#register_validate_form')[0]; // You need to use standard javascript object here
            var formData = new FormData(forms);
            $.ajax(
            {
                url: ajax_url+'profile/update_profile',
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
jQuery.validator.setDefaults(
{
    debug: true,
    success: "valid"
});