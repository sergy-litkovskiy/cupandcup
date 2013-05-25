<h2>Редактировать каталог</h2>
<div id="catalog-edit-container">
    <table>
        <tr>
            <td>
                <a class="link_backend add-category" data-num-sequence="<?php echo count($content)+1;?>" id="add_new" title="add_new" href="#">
                    <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить категорию
                </a>
            </td>
            <td>&nbsp;</td>
            <td class="catalog_edit_panel">
                <span class="control_panel">
                    edit&nbsp;|&nbsp;&nbsp;&nbsp;on&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;off&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;del
                </span>
            </td>
        </tr>
        <tr><td class="delimiter" colspan="3"></td></tr>
        <?php for($i=0; $i<=count($content)-1; $i++):?>
            <tr class="main_item" id="<?php echo $content[$i]->menu_id;?>"
                data-total-data='<?php echo json_encode($content[$i]);?>'
                data-position="<?php echo $content[$i]->products_num_sequence;?>" 
                data-prev-id-position="<?php echo isset($content[$i-1]->products_num_sequence) ? $content[$i-1]->menu_id."|".$content[$i-1]->products_num_sequence : 0;?>"
                data-next-id-position="<?php echo isset($content[$i+1]->products_num_sequence) ? $content[$i+1]->menu_id."|".$content[$i+1]->products_num_sequence : 0;?>">
                <td>    
                    <span>
                        <a href="" class="arrow_up" title="move up"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
                        <a href="" class="arrow_down" title="move down"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
                    </span>
                    <?php echo $content[$i]->products_title;?>
                </td>
                <td>&nbsp;</td>
                <td class="catalog_edit_panel">
                    <form action="#" class="edit_panel">
                        <a href="" class="edit" title="edit"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>

                        <input class="show" type="radio" value="1" name="switcher" <?php if($content[$i]->products_status == 1){?> checked="checked" <?php }?>/>
<!--                        <a href="" title="show">-->
                            <img src="<?php echo base_url()?>img/img_main/on.png"/>
<!--                        </a>-->
                        <input class="hide" type="radio" value="0" name="switcher" <?php if($content[$i]->products_status != 1){?> checked="checked" <?php }?>/>
<!--                        <a href="" title="hide">-->
                            <img src="<?php echo base_url()?>img/img_main/off.png"/>
<!--                        </a>-->

                        <a href="" class="delete" title="delete"><img src="<?php echo base_url()?>img/img_main/del.png"/></a>
                    </form>
                </td>
            </tr>
            <?php $child = $content[$i]->childs; ?>
                <!-- second level -->
                <?php for($k=0; $k<=count($child)-1; $k++):?>
                <tr class="main_item" id="<?php echo $child[$k]->menu_id;?>"
                    data-total-data='<?php echo json_encode($child[$k]);?>'
                    data-position="<?php echo $child[$k]->products_num_sequence;?>" 
                    data-prev-id-position="<?php echo isset($child[$k-1]->products_num_sequence) ? $child[$k-1]->menu_id."|".$child[$k-1]->products_num_sequence : 0;?>"
                    data-next-id-position="<?php echo isset($child[$k+1]->products_num_sequence) ? $child[$k+1]->menu_id."|".$child[$k+1]->products_num_sequence : 0;?>">
                    <td>&nbsp;</td>
                    <td>
                        <span>
                            <a href="" class="arrow_up" title="move up"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
                            <a href="" class="arrow_down" title="move down"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
                        </span>
                        <?php echo $child[$k]->products_title;?>
                    </td>
                    <td class="catalog_edit_panel">
                    <form action="#" class="edit_panel">
                        <a href="" class="edit" title="edit"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>

                        <input class="show" type="radio" value="1" name="switcher" <?php if($child[$k]->products_status == 1){?> checked="checked" <?php }?>/>
<!--                        <a href="" title="show">-->
                            <img src="<?php echo base_url()?>img/img_main/on.png"/>
<!--                        </a>-->
                        <input class="hide" type="radio" value="0" name="switcher" <?php if($child[$k]->products_status != 1){?> checked="checked" <?php }?>/>
<!--                        <a href="" title="hide">-->
                            <img src="<?php echo base_url()?>img/img_main/off.png"/>
<!--                        </a>-->

                        <a href="" class="delete" title="delete"><img src="<?php echo base_url()?>img/img_main/del.png"/></a>
                    </form>
                    </td>
                </tr>
                <?php endfor;?> 
                <tr data-parent-category-id="<?php echo $content[$i]->menu_id;?>" data-num-sequence="<?php echo count($child)+1;?>">
                    <td>&nbsp;</td>
                    <td>
                        <a class="link_backend add-subcategory" title="add_new" href="#">
                            <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить подкатегорию
                        </a>                    
                    </td>
                    <td class="catalog_edit_panel">&nbsp;</td>
                </tr>
                <tr><td class="delimiter" colspan="3"></td></tr>
        <?php endfor;?>
    </table>
</div> 
<div id="popup_mess"></div>
<?php echo $catalog_container;?>    

<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/catalog_edit_container.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/catalog_form_container.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/cups/modules/catalog_form_images.js"></script>
<script>
        CUPS.Core.registerModule("catalog-edit-container", new CatalogEditContainerModule());
        CUPS.Core.registerModule("overlay-box-container", new CatalogFormContainerModule());
        CUPS.Core.registerModule("catalog-form-images", new CatalogFormImagesModule());
</script>  