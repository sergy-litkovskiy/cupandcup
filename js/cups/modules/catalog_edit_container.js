function CatalogEditContainerModule() {
    return function(sb){
        var _validator,
            _menuEditContainer,
            _overlayMessage,
            emptyFieldMess      = 'Заполните поле';

        var _init = function() {
            _hideAllForms();
        };
        
        
        var _hideAllForms = function(){
            sb.$('div.main_menu_edit:visible').hide();
        };
        
        
        var _onSuccess = function(data){
            _overlayMessage = sb.UI.showMessage('<p class="success">' + data + '</p>');
            $(_overlayMessage).find('div.close').click(
                function(){
                    window.location.reload();
                }
            );
        }
        
        
        var _onError = function(message){
            _overlayMessage = sb.UI.showError('<p class="error">' + message + '</p>'); 
        }


        var _onClickAddCategory = function(e){
            e.preventDefault();
            sb.publish({
                type : 'catalog-form-container-show',
                data : {currentData : { products_status         : 1,
                                        products_num_sequence   : $(this).data('num-sequence')}}
            });  
        };
        
        
        var _onClickAddSubCategory = function(e){
            e.preventDefault();
          
            sb.publish({
                type : 'catalog-form-container-show',
                data : {currentData : { products_parent         : $(this).parent().parent().data('parent-category-id'),
                                        products_status         : 1,
                                        products_num_sequence   : $(this).parent().parent().data('num-sequence')}
                        }
            }); 
        };
        
        
        var _onClickEditCatalog = function(e){
            e.preventDefault();
          
            sb.publish({
                type : 'catalog-form-container-show',
                data : {currentData : $(this).parent().parent().parent().data('total-data')}
            });
        };
        
        
        var _tryDeleteCatalogItem = function(_catalogItemId){
            sb.Catalog.deleteCatalogItem(_catalogItemId, _onSuccess, _onError);
        }
        
        
        var _onClickDeleteItemMenu = function(e){
            e.preventDefault();
            var _catalogItemId = $(this).parent().parent().parent().attr('id');
          
            sb.UI.showDialog({
                    yes          : function(){ _tryDeleteCatalogItem(_catalogItemId)}
                  , message : '<p class="error">Вы уверены, что хотите удалить этот продукт?</p>'
            });
        };
        
                
        var _onClickChangeStatusItemCatalog = function(e){
            e.preventDefault();
            var _data = {
                catalogItemId : $(this).parent().parent().parent().attr('id'),
                itemStatus : $(this).val()
            };

            sb.Catalog.changeStatusCatalogItem(_data, _onSuccess, _onError);
        };
        
        
         var _onClickMoveUpItemCatalog = function(e){
            e.preventDefault();
            var _prevPositionArr    = [],
                _currentPosition    = $(this).parent().parent().parent().data('position'),
                _prevIdPosition     = $(this).parent().parent().parent().data('prev-id-position');
                _prevPositionArr    = _prevIdPosition == 0 ? 0 : _prevIdPosition.split('|');

            if(typeof _prevPositionArr == 'object'){
                var _data = {
                    currCatalogItemId   : $(this).parent().parent().parent().attr('id'),
                    currNumSequence     : _prevPositionArr[1],
                    besideCatalogItemId : _prevPositionArr[0],
                    besideNumSequence   : _currentPosition
                };
            
                sb.Catalog.changePositionCatalogItem(_data, _onSuccess, _onError);
            }
        };
        
        
        var _onClickMoveDownItemCatalog = function(e){
            e.preventDefault();
            var _nextPositionArr    = [],
                _currentPosition    = $(this).parent().parent().parent().data('position'),
                _nextIdPosition     = $(this).parent().parent().parent().data('next-id-position');
                _nextPositionArr    = _nextIdPosition == 0 ? 0 : _nextIdPosition.split('|');

            if(typeof _nextPositionArr == 'object'){
                var _data = {
                    currCatalogItemId   : $(this).parent().parent().parent().attr('id'),
                    currNumSequence     : _nextPositionArr[1],
                    besideCatalogItemId : _nextPositionArr[0],
                    besideNumSequence   : _currentPosition
                };
               
                sb.Catalog.changePositionCatalogItem(_data, _onSuccess, _onError);
            }
        };


        var _bindEvents = function() {  
            sb.bind('a.add-category', 'click', _onClickAddCategory);
            sb.bind('a.add-subcategory', 'click', _onClickAddSubCategory);
            sb.bind('form.edit_panel > a.edit', 'click', _onClickEditCatalog);
            sb.bind('.catalog_edit_panel a.delete', 'click', _onClickDeleteItemMenu);
            sb.bind('.catalog_edit_panel input.show', 'click', _onClickChangeStatusItemCatalog);
            sb.bind('.catalog_edit_panel input.hide', 'click', _onClickChangeStatusItemCatalog);
            sb.bind('.main_item a.arrow_up', 'click', _onClickMoveUpItemCatalog);
            sb.bind('.main_item a.arrow_down', 'click', _onClickMoveDownItemCatalog);
        };
        
        return {
            init : function(){
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}