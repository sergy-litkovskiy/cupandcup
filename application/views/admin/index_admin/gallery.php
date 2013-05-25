<h1>Гелерея</h1>
<div id="pretty-photo">
    <ul id="img-gallery-container">
        <?php foreach($content as $photo):?>
        <li class="edit-gallery" data-gallery-id="<?php echo $photo['id']?>">
            <form action="" class="img-gallery-switcher">
                <input class="show" type="radio" value="1" name="itemStatus" <?php if($photo['status'] == STATUS_ON){?> checked="checked" <?php }?>/>
                <img src="<?php echo base_url()?>img/img_main/on.png"/>
                <input class="hide" type="radio" value="0" name="itemStatus" <?php if($photo['status'] != STATUS_ON){?> checked="checked" <?php }?>/>
                <img src="<?php echo base_url()?>img/img_main/off.png"/>
                <a href="" class="delete" title="delete"><img src="<?php echo base_url()?>img/img_main/del.png"/></a>
            </form>            
            <img class="img-gallery" style="float: left" src="<?php echo  base_url();?>img/img_products/<?php echo  $photo['img_path'];?>"/>
            <form class="img-gallery-form" action="/admin/index_admin/ajax_gallery_upload_file" method="POST" enctype="multipart/form-data">                            
                <label>Изображение:</label>
                <input type="file" name="img_path">
                <label>Название:</label>
                <input type="text" name="title" value="<?php echo $photo['title'];?>">
                <input class="button" type="submit" value="Загрузить"/>   
            </form>
        </li>
        <?php endforeach;?>
    </ul>
</div>
<script>
        CUPS.Core.registerModule("img-gallery-container", new GalleryEditContainerModule());
</script>   