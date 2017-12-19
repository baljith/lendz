$(".switch").bootstrapSwitch();
$('.switch').on('switchChange.bootstrapSwitch', function(event, state) {
    var info =  $(this).data(state ? 'onText' : 'offText')
    var id_sent=$(this).attr('id');  
    $.ajax({
        url: ajax_url+'category/changestatus',
        type:'POST',
        dataType: 'json',
        data:{
            'id':id_sent,'Status':info
        },
        success:function(data)
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
    })
});

if ( $( "#profile_pic" ).length ) {
    var imageLoader = document.getElementById('profile_pic');
    imageLoader.addEventListener('change', readURL, false);
}
$(document).ready(function()
{
    $("#profile_pic").change(function()
    {
        if ($("#profile_pic").valid() == true)
        {
            readURL(this);
        }
    });
    
    $(".profile_upload").click(function()
    {
        $(".profile_pic_cls").trigger("click");
    });
    
    var form = $("#add_category_form");
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
            var forms = $('#add_category_form')[0]; // You need to use standard javascript object here
            var formData = new FormData(forms);
            var msgstatus="";
            $.ajax(
            {
                url: ajax_url+'category/insert',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                success: function(data)
                {
                    msgstatus = data;
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
                console.log(msgstatus);
                if(id=='') {
                    $('#add_category_form')[0].reset();
                    $('.profile_img').attr('src', '');    
                }
                
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