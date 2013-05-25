<div id="contact-block">
    <form id="contact_form" action='#' method='post' name='add_new' enctype='multipart/form-data'>
        <table class="contact">
            <tr>
                <td style="width: 50px;">
                    <p><b>Имя:</b><lable class="red_point">*</lable></p>
                </td>
                <td>
                    <input style='width:80%' id='name' name='name' value=""/>
                </td>                
                <td>
                    <p><b>E-mail:</b><lable class="red_point">*</lable></p>
                </td>
                <td>
                    <input style='width:90%' id='email' name='email' value=""/>
                </td> 
                <td rowspan="2">
                    <input id='button' class="add_mess" name='add' type='submit' value='Заказать консультацию'/>
                </td>                
            </tr>
            <tr>
                <td>
                    <p><b>Тел.:</b><lable class="red_point">*</lable></p>
                </td>
                <td>
                    <input style='width:80%' id='phone' name='phone' value=""/>
                </td>                
                <td>
                    <p><b>Город:</b><lable class="red_point">*</lable></p>
                </td>
                <td>
                    <input style='width:90%' id='city' name='city' value=""/>
                </td>
            </tr>
        </table>
    </form>
    <div id="loader" class="loader" style="display:none;">
        <img id="img_loader" src="<?php echo base_url()?>img/img_main/ajax-preloader.gif" alt="Loading"/>
    </div>    
</div>
