function OrderProductsBoxModule() {
    return function(sb){
        var _init = function() {
            sb.$('.products_item, .products_type, .products_qty').fadeOut();
            sb.$('input[type=text]').val('0').attr('disabled', 'disabled');
        };


        var _hideAndClearAllInputFieldsAfterFirst = function(container){
            container.find('input[type=checkbox]:not(:first)').removeAttr('checked');
            container.find('input[type=text]').val('0').attr('disabled', 'disabled');
        };


        var _getProductQtyName = function(data){
            var productTypeName = data.item.attr('name'),
                productTypeVal  = data.item.val();

            return productTypeName+'|'+productTypeVal;                
        };


        var _onChangeProductTypeShow = function(data) { 
            var productQtyName = _getProductQtyName(data);
            data.productListBox.find('.products_qty > input').each(function(i, item) {
                if($(item).attr('name') == productQtyName){
                    $(item).removeAttr('disabled').val('');
                }
            });
        };
        
        
        var _onChangeProductTypeHide = function(data) { 
            var productQtyName = _getProductQtyName(data);
            data.productListBox.find('.products_qty > input').each(function(i, item) {
                if($(item).attr('name') == productQtyName){
                    $(item).val('0').attr('disabled', 'disabled');
                }
            });
        };
        
        
        var _onProductTypeChangeShow = function(item) { 
            var $productListBox = item.parent().parent().parent();  
       
            if(item.is(':checked')){
                sb.publish({
                    type : 'on-change-product-type:show',
                    data : {
                        productListBox  : $productListBox,
                        item            : item
                    }
                });
            } else {
                sb.publish({
                    type : 'on-change-product-type:hide',
                    data : {
                        productListBox : $productListBox,
                        item           : item
                    }
                });
            }           
        };
        

        var _onProductTypeShow = function(productTypeItemArr) { 
            productTypeItemArr.each(function(i, item) {
                $(item).live('change', function(){ 
                    _onProductTypeChangeShow($(item)); 
                });
            });
        };

       
        var _onChangeProductShow = function(data) { 
            data.productListBox.find('.products_type, .products_qty').fadeIn(); 
            _onProductTypeShow(data.productListBox.find('.products_type input'));
        };
        
        
        var _onChangeProductHide = function(data) { 
            _hideAndClearAllInputFieldsAfterFirst(data.productListBox);
            data.productListBox.find('.products_type, .products_qty').fadeOut();
        };
        

        var _onProductChangeShow = function(item) { 
            var $productListBox = item.parent().parent();  
           
            if(item.find('input').is(':checked')){
                sb.publish({
                    type : 'on-change-product:show',
                    data : {
                        productListBox : $productListBox
                    }
                });
            } else {
                sb.publish({
                    type : 'on-change-product:hide',
                    data : {
                        productListBox : $productListBox
                    }
                });
            }           
        };
        
        
        var _onProductListShow = function(productListItemArr) { 
            productListItemArr.each(function(i, item) {
                $(item).live('change', function(){ 
                    _onProductChangeShow($(item)); 
                });
            });
        };
        
        
        var _onChangeCategoryShow = function(data) { 
            var productListItemArr = data.productListBox.find('.products_item');
            productListItemArr.fadeIn();
            _onProductListShow(productListItemArr);
        };
        
        
        var _onChangeCategoryHide = function(data) { 
            _hideAndClearAllInputFieldsAfterFirst(data.productListBox);
            data.productListBox.find('.products_item, .products_type, .products_qty').fadeOut();
        };

        
        var _onChangeCategory = function($this) { 
            var $productListBox = $($this).parent().parent().parent().parent();

            if($($this).is(':checked')){
                sb.publish({
                    type : 'on-change-category:show',
                    data : {
                        productListBox : $productListBox
                    }
                });
            } else {
                sb.publish({
                    type : 'on-change-category:hide',
                    data : {
                        productListBox : $productListBox
                    }
                });
            }
        };
              
        
        var _onClickReset = function(data) { 
            var $overlayContainer = data.overlay;
            $overlayContainer.find('input[type=checkbox]').removeAttr('checked');
            $overlayContainer.find('.products_qty  > input[type=text]').val('0').prop("disabled", true);
            $overlayContainer.find('.products_item, .products_type, .products_qty').fadeOut();
        };
        
              
        var _bindEvents = function() {  
            sb.$('.category > input[type=checkbox]').live('change', function(){ _onChangeCategory(this); });
        };
        
        
        return {
            init : function(){
                _init();
                _bindEvents();
                sb.subscribe({
                    'on-change-category:show'       : _onChangeCategoryShow,
                    'on-change-category:hide'       : _onChangeCategoryHide,
                    'on-change-product:show'        : _onChangeProductShow,
                    'on-change-product:hide'        : _onChangeProductHide,
                    'on-change-product-type:show'   : _onChangeProductTypeShow,
                    'on-change-product-type:hide'   : _onChangeProductTypeHide,
                    'on-click-reset'                : _onClickReset
                });
            },
            destroy : function(){ }
        };
    }
}