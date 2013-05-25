<h1><?php echo $categories[0]['parent_title'];?></h1>
<div class="product_nav_panel">
    <span>
        <ul class="products_menu">
            <?php foreach($categories as $category):?> 
                <li class="products_items">
                    <a href="<?php echo base_url()."catalog/".$category['parent_slug']."/".$category['products_slug']?>" <?php if(in_array($category['products_slug'], $url_segments)){ echo 'class="active"';}?>>
                        <div>
                            <?php echo $category['products_title']?>
                        </div>
                    </a>
                </li>
            <?php endforeach;?> 
        </ul>
    </span>
</div>