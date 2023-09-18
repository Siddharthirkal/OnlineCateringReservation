<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    
    <div class="row">
    <h3 class="float-right">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
        <div class="col-lg-12">
            <h3 class="text-center">Login</h3>
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form" name="email" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="create_account">Create Account</a>
                    <button class="btn btn-primary btn-flat">Login</button>
                </div>
            </form>
            <div class="text-center">
                <a href="javascript:void()" id="forgot_password">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>
<div id="forgot_password_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forgot-password-form">
                    <div class="form-group">
                        <label for="forgot_email">Email</label>
                        <input type="email" class="form-control" id="forgot_email" name="forgot_email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#create_account').click(function(){
            uni_modal("","registration.php","mid-large")
        })
         // Show the "Forgot Password" modal
         $('#forgot_password').click(function () {
            $('#forgot_password_modal').modal('show');
        });

        // Handle the "Forgot Password" form submission
        $('#forgot-password-form').submit(function (e) {
            e.preventDefault();
            var email = $('#forgot_email').val();
            $.ajax({
            url: 'forgot_password.php', // Change this to the correct path of your PHP script
            method: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function (resp) {
                if (resp.status == 'success') {
                    alert('Password reset email sent. Please check your email.');
                    $('#forgot_password_modal').modal('hide');
                } else {
                    alert('Error: Unable to process your request. Please try again later.');
                }
            },
            error: function (err) {
                console.log(err);
                alert('An error occurred while processing your request.');
            }
        });
    }); 
        $('#login-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Login.php?f=login_user",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Login Successfully",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'incorrect'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })
</script>