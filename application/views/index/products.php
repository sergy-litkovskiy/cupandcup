<?php echo $categories;?>
<div id="main_content">
    <div class="product_img">
        <?php if( @$product['img_white']){
            echo '<img style="height:166px" src="'. base_url() .'img/img_products/'. @$product["img_white"].'" alt="'. @$product["products_title"].'"/>';
        };?>            
        <?php if( @$product['img_color']){
            echo '<img style="height:166px" src="'. base_url() .'img/img_products/'. @$product["img_color"].'" alt="'. @$product["img_color"].'"/>';
        };?>   
        <table class="product_price" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="2">
                    <p class="product"><b>Цена за 1000 шт.</b> на <?php echo date('d-m-Y');?> составляет:</p>
                </td>
            </tr>
            <tr>
                <?php if( @$product['price_white']){
                    echo '<td><p class="product">Без рисунка: '. @$product['price_white'].' грн.</p></td>';
                }

                if( @$product['price_color']){
                    echo '<td><p class="product">С типовым рисунком: '. @$product['price_color'].' грн.</p></td>';
                };?>
            </tr>
        </table>
    </div>
    <div class="product_description">
        <?php foreach($product['product_description'] as $name_description => $val_description):
            echo '<p class="product"><b>'.$name_description.'</b> '.$val_description.'</p>';
         endforeach;?>

        <?php if( @$product['amount_rukav']){
            echo '<p class="product"><b>В упаковке-рукаве: </b>'. @$product['amount_rukav'].' шт.</p>';
        };?>        
        <?php if( @$product['amount_box']){
            echo '<p class="product"><b>В упаковке-коробке: </b>'. @$product['amount_box'].' шт.</p>';
        };?>
        <span id="order-button">
            <input type="button" id="button" name="order" value="Заказать"/>
        </span>
    </div>
</div>
<?php echo @$order_container;?>