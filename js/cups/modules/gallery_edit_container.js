function GalleryEditContainerModule() {
    return function(sb){
           
        var _onError = function(message){
            sb.UI.showError('<p class="error">' + message + '</p>'); 
        }
        
        
        var _trySubmitCatalogForm = function($formImageContainer){
            var currentImg = $($formImageContainer).parent().next().find('img'),
                oldImgPath = currentImg.attr('src');
            currentImg.attr('src', 'http://'+location.hostname+'/img/img_main/ajax-loader_red.gif');
          
            $($formImageContainer).ajaxSubmit(
                function(response){
                    var responseObj = response.length ? sb.JSON.parseSbJSON(response) : {};
                    if(responseObj.success){
                        currentImg.attr('src', 'http://'+location.hostname+'/img/img_products/'+responseObj.data);
                        sb.publish({
                            type : 'catalog-new-image-uploaded',
                            data : {
                                    newImageName : responseObj.data, 
                                    newImageType : $($formImageContainer).find('input[name=img-type-name]').val()
                                }
                        });
                    } else {
                        if(responseObj.message) _onError(responseObj.message);
                        currentImg.attr('src',oldImgPath);
                    }
                    $($formImageContainer).resetForm();
                }
            );
        };

        
        var _onClickUpload = function(e){
            e.preventDefault();
            var $formImageContainer = $(this).parent();
         
            if($('input[type=file]', $formImageContainer).val()){
                _trySubmitCatalogForm($formImageContainer);
            } else {
                alert('Не выбран файл для зaгрузки!');
            }
            return false;
        };
        
        
        
        var _onChangeRadioSwitcher = function(e){
console.log();         
            var _currentGalleryId = $(this).parent().parent().data('gallery-id');
//            try{
//                if($($overlayContainer).find('form#catalog-form').valid()){
//                    _trySubmitCatalogForm(_makeCatalogItemArr());
//                } 
//            } catch(errMess){
//                alert(errMess);
//            }
//            return false;
        };
        
        
        
        var _bindEvents = function() { 
            sb.bind('.img-gallery-switcher input[name=switcher]', 'change', _onChangeRadioSwitcher);
        };
        
        return {
            init : function(){
console.log('here');                
                sb.subscribe({
//                    'catalog-form-container-visible'   : _bindEvents
                });
                _bindEvents();                
            },
            destroy : function(){ }
        };
    }
}