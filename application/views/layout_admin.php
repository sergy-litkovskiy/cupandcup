<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
    <?php echo head_htm_backend();?>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="<?php echo base_url();?>backend/login" ALT="На главную">
                <div class="logo"><p>Тел. (050) 330 13 67</p></div>
            </a>
            <div class="slider">
                <div id="slide"></div>
            </div>
        </div>
        <div class="content_block">
            <div class="menu">
                <?php echo @$menu;?>
            </div>
            <div class="content">
                <?php echo @$content;?>
            </div>
        </div>
        <div class="footer">
            <p id="copyright">&copy; 2009 "Коллор Украина"</p>
            <a id="author" href="#">Design &amp; programming by Sergy Litkovskiy</a>
        </div>
    </div>
    <?php //echo show_tinymce();?>
</body>
   
<script>
        CUPS.Core.startAll();
</script>     
</html>