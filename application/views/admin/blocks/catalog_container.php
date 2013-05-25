<div id="overlay-box-container" style="display: none">
    <div id="wrap-order">
            <h2 class="edit_catalog_action"></h2>
            <table class="menu_detail_edit">
                <tr>
                    <td>
                        <label class="red_point">Название:*</label>
                    </td>
                    <td>
                        <label class="red_point">Slug:*</label>
                    </td>
                    <td>
                        <label>Объём:</label>
                    </td>
                    <td>
                        <label>Ламинирование:</label>
                    </td>
                </tr>
                <form id="catalog-form" action="#" method="POST" enctype="multipart/form-data"> 
                    <tr>
                        <td>
                            <input type="text" class="edit_detail" value="" name="title"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="slug"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="volume"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="laminir"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Кол-во в коробке:</label>
                        </td>
                        <td>
                            <label>Кол-во в рукаве:</label>
                        </td>
                        <td>
                            <label>Цена за белый:</label>
                        </td>
                        <td>
                            <label>Цена за рисунок:</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="edit_detail" value="" name="amount_box"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="amount_rukav"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="price_white"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="price_color"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Температура С&ring;:</label>
                        </td>
                        <td>
                            <label>Тип бумаги:</label>
                        </td>
                        <td colspan="2">
                            <label>Seo title:</label>
                        </td>
                    </tr>  
                    <tr>
                        <td>
                            <input type="text" class="edit_detail" value="" name="temperature"/>
                        </td>
                        <td>
                            <input type="text" class="edit_detail" value="" name="type_paper"/>
                        </td>
                        <td colspan="2">
                            <input type="text" class="edit_detail" value="" name="seo_title"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Seo description:</label>
                        </td>
                        <td colspan="2">
                            <label>Seo keywords:</label>
                        </td>
                    </tr>                    
                    <tr>
                        <td colspan="2">
                            <textarea class="edit_detail" name="seo_description"></textarea>
                        </td>
                        <td colspan="2">
                            <textarea class="edit_detail" name="seo_keywords"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <label>Текст:</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <textarea class="edit_detail" name="description"></textarea>
                            <input type="hidden" name="num_sequence" value="">
                            <input type="hidden" name="status" value="">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="parent" value="">
                            <input type="hidden" name="properties_id" value="">
                            <input type="hidden" name="old_img_white" value="">
                            <input type="hidden" name="old_img_color" value="">
                            <input type="hidden" name="img_white" value="">
                            <input type="hidden" name="img_color" value="">                            
                        </td>
                    </tr>
                </form>                
                <tr>
                    <td colspan="4" class="upload_img_text">
                        <label>Загрузка изображения:</label>
                    </td>
                </tr>  
                <tr id="catalog-form-images">
                    <td>
                        <form id="catalog-form-images-white" action="/admin/index_admin/ajax_catalog_upload_file" method="POST" enctype="multipart/form-data">                            
                            <label>Без рисунка:</label>
                            <input type="file" name="catalog-img-white">
                            <input type="hidden" name="img-type-name" value="white"/>
                            <input class="button_upload_img" type="submit" value="Загрузить"/>   
                        </form>
                    </td>
                    <td class="images">
                        <img id="img-white" class="catalog-form-images-white" src=""/>
                    </td>
                    <td>
                        <form id="catalog-form-images-color" action="/admin/index_admin/ajax_catalog_upload_file" method="POST" enctype="multipart/form-data"> 
                            <label>С типовым рисунком:</label>
                            <input type="file" name="catalog-img-color">
                            <input type="hidden" name="img-type-name" value="color"/>
                            <input class="button_upload_img" type="submit" value="Загрузить"/>
                        </form>                            
                    </td>
                    <td class="images">
                        <img id="img-color" class="catalog-form-images-color" src=""/>                        
                    </td>
                </tr>                
                <tr>
                    <td colspan="4">
                        <input class="button_submit" type="submit" value="Сохранить"/>
                        <input class="button_close" value="Закрыть"/>
                    </td>
                </tr>
            </table>
    </div> 
</div>
<div id="loader" class="loader" style="display:none;">
    <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
</div>