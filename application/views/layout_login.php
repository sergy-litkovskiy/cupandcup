<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
    <?php echo head_htm_backend();?>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="<?php echo base_url();?>" ALT="На главную">
                <div class="logo"><p>Тел. (050) 330 13 67</p></div>
            </a>
            <div class="slider"></div>
        </div>
        <div class="content_block">
            <div class="content">
                <?php echo @$content;?>
            </div>
        </div>
        <div class="footer">
            <p id="copyright">&copy; 2009 "Коллор Украина"</p>
            <a id="author" href="#">Design &amp; programming by Sergy Litkovskiy</a>
        </div>
    </div>
</body>
<script  type="text/javascript" src="<?php echo base_url();?>js/init.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/core.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/core.extensions.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/sandbox.js"></script> 
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/login.js"></script>
<script>
        CUPS.Core.registerModule("login-block", new LoginModule());
        CUPS.Core.startAll();
</script>  
</html>