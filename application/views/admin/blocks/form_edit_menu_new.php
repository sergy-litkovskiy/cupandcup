<div class="main_menu_edit_new">
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
                <input type="text" class="edit_detail" value="" name="title"/>
            </td>
            <td>
                <input type="text" class="edit_detail" value="" name="slug"/>
            </td>
        </tr>
        <tr>
            <td collspan="2">
                <label>Seo title:</label>
            </td>
        </tr>  
        <tr>
            <td collspan="2">
                <input type="text" class="seo_title" value="" name="seo_title"/>
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
                <textarea name="seo_description"/></textarea>
            </td>
            <td>
                <textarea name="seo_keywords"/></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>Текст:</label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <textarea id="full" class="edit_detail_full" name="description"/></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="num_sequence" value="">
                <input type="hidden" name="status" value="">
                <input type="hidden" name="id" value="">
                <input class="button_submit" type="submit" value="Сохранить"/>
            </td>
        </tr>
    </table>
</form>
</div>