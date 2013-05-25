<h2>Редактировать меню</h2>
<div id="menu-edit-container-new">
    <div class="add_new">
        <p>
            <a class="link_backend" id="add_new" title="add_new" href="#">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить раздел
            </a>
        </p>
    </div>
    <?php echo $form_menu_edit_new;?>
</div>
<div id="menu-edit-container">
    <div id="menu-edit-mce">
            <div class="main_item">
                <span>&nbsp;</span>
                <span>&nbsp;</span>
                <span class="control_panel">
                    edit&nbsp;|&nbsp;&nbsp;&nbsp;on&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;off&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;del
                </span>
            </div>
        <?php for($i=0; $i<=count($menu)-1; $i++):?>
            <div class="main_item" id="<?php echo $menu[$i]->id;?>" 
                 data-position="<?php echo $menu[$i]->numSeq;?>" 
                 data-prev-id-position="<?php echo isset($menu[$i-1]->numSeq) ? $menu[$i-1]->id."|".$menu[$i-1]->numSeq : 0;?>"
                 data-next-id-position="<?php echo isset($menu[$i+1]->numSeq) ? $menu[$i+1]->id."|".$menu[$i+1]->numSeq : 0;?>">
                <span>
                    <a href="" class="arrow_up" title="move up"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
                    <a href="" class="arrow_down" title="move down"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
                </span>
                <span>
                    <?php echo $menu[$i]->title;?>
                </span>
                <form action="#" class="edit_panel">
                    <a href="" class="edit" title="edit"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>
                    
                    <input class="show" type="radio" value="1" name="switcher" <?php if($menu[$i]->status == 1){?> checked="checked" <?php }?>/>
                    <a href="" title="show"><img src="<?php echo base_url()?>img/img_main/on.png"/></a>
                    <input class="hide" type="radio" value="0" name="switcher" <?php if($menu[$i]->status != 1){?> checked="checked" <?php }?>/>
                    <a href="" title="hide"><img src="<?php echo base_url()?>img/img_main/off.png"/></a>
                    
                    <a href="" class="delete" title="delete"><img src="<?php echo base_url()?>img/img_main/del.png"/></a>
                </form>
            </div>
            <div class="main_menu_edit">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <table class="menu_detail_edit">
                        <tr>
                            <td>
                                <label>Название:</label>
                            </td>
                            <td>
                                <label>Slug:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="edit_detail" value="<?php echo $menu[$i]->title;?>" name="title"/>
                            </td>
                            <td>
                                <input type="text" class="edit_detail" value="<?php echo $menu[$i]->slug;?>" name="slug"/>
                            </td>
                        </tr>
                        <tr>
                            <td collspan="2">
                                <label>Seo title:</label>
                            </td>
                        </tr>  
                        <tr>
                            <td collspan="2">
                                <input type="text" class="seo_title" value="<?php echo $menu[$i]->seo_title;?>" name="seo_title"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Seo description:</label>
                            </td>
                            <td>
                                <label>Seo keywords:</label>
                            </td>
                        </tr>                    
                        <tr>
                            <td>
                                <textarea name="seo_description"><?php echo $menu[$i]->seo_description;?></textarea>
                            </td>
                            <td>
                                <textarea name="seo_keywords"><?php echo $menu[$i]->seo_keywords;?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label>Текст:</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea id="full<?php echo $menu[$i]->id;?>" class="edit_detail_full" name="description"><?php echo $menu[$i]->description;?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="num_sequence" value="<?php echo $menu[$i]->numSeq;?>">
                                <input type="hidden" name="status" value="<?php echo $menu[$i]->status;?>">
                                <input type="hidden" name="id" value="<?php echo $menu[$i]->id;?>">
                                <input class="button_submit" type="submit" value="Сохранить"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <?php endfor;?>
    </div>
</div> 
<div id="popup_mess"></div>
<script>
        CUPS.Core.registerModule("menu-edit-container", new MenuEditContainerModule());
        CUPS.Core.registerModule("menu-edit-container-new", new MenuEditContainerNewModule());
        CUPS.Core.registerModule("menu-edit-mce", new TinymceInitModule());
</script>   