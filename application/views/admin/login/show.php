<div id="login-block">
    <h2>Authorization:</h2>
    <form id="login-form" action='<?php echo base_url();?>backend/login' method='post' name='add_new' enctype='multipart/form-data'>
    <p class="error"><?php echo validation_errors(); ?></p>
    <table class="login_form">
        <tr>
            <td>
                <p><b>Login:</b><lable class="red_point">*</lable></p>
            </td>
            <td>
                <input type="text" style='width:100%' id='log' name='log' value="<?php echo set_value('log');?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <p><b>Password:</b><lable class="red_point">*</lable></p>
            </td>
            <td>
                <input type="password" style='width:100%' id='pass' name='pass' value="<?php echo set_value('pass');?>"/>
            </td>
        </tr>
        
    </table>
            <input id='button_login' class="add_mess" name='add' type='submit' value='Send'/>
    </form>
</div>