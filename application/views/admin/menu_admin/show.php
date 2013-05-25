<h2>Редактировать меню</h2>
<?php for($i=0; $i<=count($content['menu'])-1; $i++):?>
    <div class="main_item" id="<?php echo $content['menu'][$i]->id;?>" parent="<?php echo $content['menu'][$i]->parent;?>" position="<?php echo $content['menu'][$i]->numSeq;?>">
        <span>
            <a href="" class="arrow_up" title="move up"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
            <a href="" class="arrow_down" title="move down"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
        </span>
        <span>
            <?php echo $content['menu'][$i]->title;?>
        </span>
        <span class="edit_panel">
            <a href="" class="arrow_up" title="edit"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
            <a href="" class="arrow_down" title="show"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
            <a href="" class="arrow_down" title="hide"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
            <a href="" class="arrow_down" title="delete"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
        </span>
    </div>
<?php endfor;?>
  
<div id="mess_mailsent"></div>