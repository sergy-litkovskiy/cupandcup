<ul class="main_menu">
    <li><span class='category'>Продукция</span></li>
    <?php for($i=0; $i<=count($menu_catalog)-1; $i++):?>
        <?php
            if(!$menu_catalog[$i]->childs) {
                echo "<li><span class='has_child'>".$menu_catalog[$i]->title."</span>";
            } else {
                echo "<li>";
                if(in_array($menu_catalog[$i]->slug, $url_segments)){
                    echo "<span id='active_subcat'>".$menu_catalog[$i]->title."</span>";
                } else {
                    echo "<a class='subcategory' href='".base_url().'catalog/'.$menu_catalog[$i]->slug."'>".$menu_catalog[$i]->title."</a>";
                }
            }
        ?>
            </li>
    <?php endfor;?>
</ul>
<ul class="main_menu">
    <?php for($i=0; $i<=count($menu)-1; $i++):?>
        <?php
            if($menu[$i]->childs) {
                echo "<li><span class='has_child'>".$menu[$i]->title."</span>";
            } else {
                echo "<li>";
                 if(in_array($menu[$i]->slug, $url_segments)){
                    echo "<span id='active_category'>".$menu[$i]->title."</span>";
                } else {
                    echo "<a class='category' href='".base_url().'show/'.$menu[$i]->slug."'>".$menu[$i]->title."</a>";
                }
            }
        ?>
        <?php $child = $menu[$i]->childs; ?>
            <ul>
                <?php for($k=0; $k<=count($child)-1; $k++):
                        echo "<li class='drop_item'>"; 
                        if(in_array($child[$k]->slug, $url_segments)){
                            echo "<span id='active'>".$child[$k]->title."</span>";
                        } else {
                            echo "<a class='subcategory' href='".base_url().'show/'.$child[$k]->slug."'>".$child[$k]->title."</a>";
                        }
                        echo "<li>";
                endfor;?>
            </ul>
            </li>
    <?php endfor;?>
</ul>
<ul class="main_menu">
<!--    <li><a class='category' href='<?php // echo base_url();?>gallery'>Галерея</a></li>-->
</ul>