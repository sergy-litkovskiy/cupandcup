<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
    <?php echo head_htm();?>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="<?php echo base_url();?>" ALT="На главную">
                <div class="logo"><p>Тел. (050) 330 13 67</p></div>
            </a>
            <div class="slider">
                <div id="slide"></div>
            </div>
        </div>
        <div class="content_block">
            <div class="menu">
                <?php echo $menu;?>
            </div>
            <div class="content">
                <?php echo @$content;?>
            </div>
        </div>
        <div class="footer">
            <p id="copyright">&copy; 2009-2012 "Коллор Украина"</p>
            <a id="author" href="#">Design &amp; programming by Sergy Litkovskiy</a>
        </div>
    </div>
</body>
<script  type="text/javascript" src="<?php echo base_url();?>js/init.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/core.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/core.extensions.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/sandbox.js"></script> 
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/order_container.js"></script> 
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/order_button.js"></script> 
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/order_products_box.js"></script> 
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/contact_form.js"></script> 
<!--<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/pretty_photo.js"></script> -->
<script>
        CUPS.Core.registerModule("order-button", OrderButtonModule());
        CUPS.Core.registerModule("overlay-box-container", OrderContainerModule());
        CUPS.Core.registerModule("order-products-box", OrderProductsBoxModule());
        CUPS.Core.registerModule("contact-block", ContactFormModule());
//        CUPS.Core.registerModule("pretty-photo", PrettyPhotoModule());
        CUPS.Core.startAll();
</script>  
</html>




