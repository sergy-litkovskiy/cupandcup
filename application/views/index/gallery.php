<h1>Гелерея</h1>
<div id="pretty-photo">
    <ul>
        <?php foreach($content as $photo):?>
        <li>
            <a style="float: left" href="<?php echo  base_url();?>img/img_products/<?php echo  $photo['img_path'];?>" rel="prettyPhoto[]" 
            alt="<p id='pretty'><?php echo  $photo['title'];?></p>">
            <img style="float: left" src="<?php echo  base_url();?>img/img_products/<?php echo  $photo['img_path'];?>"/>
            </a>
        </li>
        <?php endforeach;?>
    </ul>
</div>