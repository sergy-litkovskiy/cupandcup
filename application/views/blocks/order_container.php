<div id="overlay-box-container" style="display: none">
    <div id="wrap-order">
    <h1>Форма заказа:</h1>
    <form id="order_form" action='#' method='post' name='add_new' enctype='multipart/form-data'>
        <table class="order">
            <tr>
                <td class="order_form_title">
                    <p>
                        <label for="name_payer"><b>Имя заказчика:</b><sup>*</sup></lable>
                    </p>
                </td>
                <td  class="order_form_input">
                    <input type="text" style='width:95%' id='name_payer' name='name_payer' value=""/>
                </td>
                <td class="order_form_title">
                    <p>
                        <label for="name_recipient"><b>Имя получателя:</b><sup>*</sup></lable>
                    </p>
                </td>
                <td  class="order_form_input">
                    <input type="text" style='width:95%' id='name_recipient' name='name_recipient' value=""/>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <label for="email"><b>E-mail заказчика:</b><sup>*</sup></lable>
                    </p>
                </td>
                <td>
                    <input type="text" style='width:95%' id='email' name='email' value=""/>
                </td>
                <td>
                    <p>
                        <label for="city"><b>Город:</b><sup>*</sup></lable>
                    </p>
                </td>
                <td>
                    <input type="text" style='width:95%' id='city' name='city' value=""/>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <label for="phone"><b>Телефон заказчика:</b><sup>*</sup></lable>
                    </p>
                </td>
                <td>
                    <input type="text" style='width:95%' id='phone' name='phone' value=""/>
                </td>

                <td>
                    <p>
                        <label for="delivery"><b>Доставка:</b></lable>
                    </p>
                </td>
                <td>
                    <p>Доставка по Киеву - от 50 тыс. стаканов.</p>
                    <p>Меньшее кол-во стаканов - самовывоз.</p>
                    <p>Доставка в другие города осуществляется компаниями-перевозчиками - услуги оплачивает получатель.</p>
<!--                    <input type="radio" id='delivery' name='delivery' checked="checked" value="0"/>&nbsp;<span>Самовывоз</span><br/>
                    <input type="radio" id='delivery' name='delivery' value="1"/>&nbsp;<span>Доставка производителя</span>-->
                </td>
            </tr> 
            <tr class="products" id="order-products-box">
                <td>
                    <p>
                        <label for="products"><b>Вид продукции:</b><sup>*</sup></lable>
                    </p>
                </td>
                <td colspan="5">
                <?php foreach($catalog_items as $item):?> 
                    <table class="product_list">
                        <tr>
                            <td rowspan="<?php echo count($item->childs);?>">
                                <div class="category">
                                    <input type="checkbox" name='<?php echo "$item->slug";?>' value="<?php echo "$item->id";?>"/>
                                    &nbsp;<span><?php echo "$item->title";?></span>
                                </div>
                            </td>
                        <?php foreach($item->childs as $childs):?> 
                            <td></td>
                            <td>
                                <div class="products_item">
                                    <input type="checkbox" name='<?php echo $item->slug."|".$childs->slug;?>' value="<?php echo $childs->id;?>"/>
                                    &nbsp;<span><?php echo $childs->title;?></span>
                                </div>
                            </td>
                            <td>
                                <div class="products_type">
                                    
                                    <input type="checkbox" name='<?php echo $item->slug."|".$childs->id;?>' value="1"/>
                                    &nbsp;<span>без рисунка</span><br/>
                                    <?php if($childs->price_color){?>
                                        <input type="checkbox" name='<?php echo $item->slug."|".$childs->id;?>' value="2"/>
                                        &nbsp;<span>с типовым рисунком</span><br/>
                                        <input type="checkbox" name='<?php echo $item->slug."|".$childs->id;?>' value="3"/>
                                        &nbsp;<span>с индивид. полиграфией</span><br/>
                                    <?php }?>
                                </div>
                            </td>
                            <td>
                                <div class="products_qty">
                                    <span>кол-во</span>&nbsp;<input maxlength="7" data-parenttitle="<?php echo $item->title;?>" data-producttitle="<?php echo $childs->title;?>" data-propertytype="<?php echo "без рисунка";?>" class="quantity" disabled="disabled" type="text" name='<?php echo $item->slug."|".$childs->id."|1";?>' value="0"/>
                                    &nbsp;<span>шт.</span><br/>
                                    <?php if($childs->price_color){?>
                                        <span>кол-во</span>&nbsp;<input maxlength="7" data-parenttitle="<?php echo $item->title;?>" data-producttitle="<?php echo $childs->title;?>" data-propertytype="<?php echo "с типовым рисунком";?>" class="quantity" disabled="disabled" type="text" name='<?php echo $item->slug."|".$childs->id."|2";?>' value="0"/>
                                        &nbsp;<span>шт.</span><br/>
                                        <span>кол-во</span>&nbsp;<input maxlength="7" data-parenttitle="<?php echo $item->title;?>" data-producttitle="<?php echo $childs->title;?>" data-propertytype="<?php echo "с индивид. полиграфией";?>" class="quantity" disabled="disabled" type="text" name='<?php echo $item->slug."|".$childs->id."|3";?>' value="0"/>
                                        &nbsp;<span>шт.</span><br/>
                                    <?php }?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>  
                    </table>
                <?php endforeach;?>                      
                </td>
            </tr>              
            <tr>
                <td>
                    <p>
                        <label for="text"><b>Дополнительная информация:</b></label>
                    </p>
                </td>
                <td colspan="5">
                    <textarea style='width:90%' id='text' name='text' cols='40' rows='3'></textarea>
                </td>
            </tr>
        </table>
        <div id="order-button-panel">
            <input class='button_submit' name='place_order' type='submit' value='Отправить'/>
            <input class='button_reset' name='reset_order' type='reset' value='Очистить'/>
            <input class='button_close' name='close_order' type='button' value='Закрыть'/>
        </div>
        <br/><br/><br/><br/>
    </form>
    </div> 
</div>
<div id="loader" class="loader" style="display:none;">
    <img id="img_loader" src="<?php echo base_url();?>img/img_main/ajax-preloader.gif" alt="Loading"/>&nbsp;&nbsp;&nbsp;&nbsp;<span class="loader_text">ЗАГРУЗКА</span>
</div>