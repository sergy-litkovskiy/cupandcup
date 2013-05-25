function CatalogFormContainerModule() {
    return function(sb){
        var $overlayContainer   = {},
        $overlayMessageContainer = {},
            emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator;
            
            
        var _init = function() {
            _hide();
        };
        

        var _assignValidator = function(e) {
            _validator = $($overlayContainer).find('form#catalog-form').validate({
                    rules: {
                        title: {
                            required: true,
                            minlength: 3
                        },
                        slug: {
                            required: true,
                            minlength: 3
                        }
                    },
                    messages: {
                        title: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        slug: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        }
                    }
                });
        };


        var _hide = function(cb) {
            sb.$self().fadeOut(cb);
        };
        
        
        var _fillCatalogForm = function(data){
            $('input[name=title]', $overlayContainer).val(data.products_title);
            $('input[name=slug]', $overlayContainer).val(data.products_slug);
            $('input[name=volume]', $overlayContainer).val(data.volume);
            $('input[name=laminir]', $overlayContainer).val(data.laminir);
            
            $('input[name=amount_box]', $overlayContainer).val(data.amount_box);
            $('input[name=amount_rukav]', $overlayContainer).val(data.amount_rukav);
            $('input[name=price_white]', $overlayContainer).val(data.price_white);
            $('input[name=price_color]', $overlayContainer).val(data.price_color);
            
            $('input[name=temperature]', $overlayContainer).val(data.temperature);
            $('input[name=type_paper]', $overlayContainer).val(data.type_paper);
            $('input[name=seo_title]', $overlayContainer).val(data.products_seo_title);
            
            $('textarea[name=seo_description]', $overlayContainer).val(data.products_seo_description);
            $('textarea[name=seo_keywords]', $overlayContainer).val(data.products_seo_keywords);
            $('textarea[name=description]', $overlayContainer).val(data.description);
            
            $('input[name=num_sequence]', $overlayContainer).val(data.products_num_sequence || 0);
            $('input[name=status]', $overlayContainer).val(data.products_status || 0);
            $('input[name=id]', $overlayContainer).val(data.products_id || 0);
            $('input[name=parent]', $overlayContainer).val(data.products_parent || 0);
            $('input[name=properties_id]', $overlayContainer).val(data.id || 0);
            $('input[name=old_img_white]', $overlayContainer).val(data.img_white);
            $('input[name=old_img_color]', $overlayContainer).val(data.img_color);
            
            $('img#img-white', $overlayContainer).attr('src', 'http://'+location.hostname+'/img/img_products/'+data.img_white);
            $('img#img-color', $overlayContainer).attr('src', 'http://'+location.hostname+'/img/img_products/'+data.img_color);
        };
	

        
        var _onCatalogFormContainerShow = function(data){
            if(!data.currentData) return;
           
            var params = {el : '#' + sb.$self().attr('id')};
            $overlayContainer = sb.UI.showOverlay(params);
            _fillCatalogForm(data.currentData);
            _assignValidator();
            _bindEvents();
            _clearImagesPath(); 
            sb.publish({
                type : 'catalog-form-container-visible'
            });
        };
               
                
        var _makeCatalogItemArr   = function(){

            return {             
                title           : $('input[name=title]', $overlayContainer).val(),
                slug            : $('input[name=slug]', $overlayContainer).val(),
                volume          : $('input[name=volume]', $overlayContainer).val(),
                laminir         : $('input[name=laminir]', $overlayContainer).val(),

                amount_box      : $('input[name=amount_box]', $overlayContainer).val(),
                amount_rukav    : $('input[name=amount_rukav]', $overlayContainer).val(),
                price_white     : $('input[name=price_white]', $overlayContainer).val(),
                price_color     : $('input[name=price_color]', $overlayContainer).val(),

                temperature     : $('input[name=temperature]', $overlayContainer).val(),
                type_paper      : $('input[name=type_paper]', $overlayContainer).val(),
                seo_title       : $('input[name=seo_title]', $overlayContainer).val(),

                seo_description : $('textarea[name=seo_description]', $overlayContainer).val(),
                seo_keywords    : $('textarea[name=seo_keywords]', $overlayContainer).val(),
                description     : $('textarea[name=description]', $overlayContainer).val(),
                
                num_sequence    : $('input[name=num_sequence]', $overlayContainer).val(),
                status          : $('input[name=status]', $overlayContainer).val(),
                id              : $('input[name=id]', $overlayContainer).val(),
                parent          : $('input[name=parent]', $overlayContainer).val(),
                properties_id   : $('input[name=properties_id]', $overlayContainer).val(),
                old_img_white   : $('input[name=old_img_white]', $overlayContainer).val(),
                old_img_color   : $('input[name=old_img_color]', $overlayContainer).val(),
                img_white       : $('input[name=img_white]', $overlayContainer).val(),
                img_color       : $('input[name=img_color]', $overlayContainer).val()
            };
        };
        
        
        var _onSuccess = function(data){
            $overlayMessageContainer = sb.UI.showMessage('<p class="success">' + data + '</p>');
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    window.location.reload();
                }
            );
        }
        
        
        var _onError = function(message){
            $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>'); 
        }
        
        
        var _trySubmitCatalogForm = function(catalogItemArr){
            sb.Catalog.addOrUpdate(catalogItemArr, _onSuccess, _onError);
        };

        
        var _onClickSubmit = function(e){
            e.preventDefault();
            try{
                if($($overlayContainer).find('form#catalog-form').valid()){
                    _trySubmitCatalogForm(_makeCatalogItemArr());
                } 
            } catch(errMess){
                alert(errMess);
            }
            return false;
        };
        
        
        var _onClickClose = function(){
            $($overlayContainer).find('p.error-message').remove();
            $($overlayContainer).find('input[type=text], textarea').val('');
            $('#'+sb.$self().attr('id')).overlay().close();
        };
        
        
        var _clearImagesPath = function(){
            $($overlayContainer).find('input[name=img_white], input[name=img_color]').val('');
        };
        

        var _onNewImageUploaded = function(data){
            $($overlayContainer).find('input[name=img_'+data.newImageType+']').val(data.newImageName);
        };
        
        
        var _bindEvents = function() {  
            $overlayContainer.on('click', 'input.button_submit',_onClickSubmit);
            $overlayContainer.on('click', 'input.button_close', _onClickClose);
        };
        
        return {
            init : function(){
                _init();
                sb.subscribe({
                    'catalog-form-container-show'   : _onCatalogFormContainerShow,
                    'on-click-close'                : _onClickClose,
                    'catalog-new-image-uploaded'    : _onNewImageUploaded
                });
            },
            destroy : function(){ }
        };
    }
}