function OrderContainerModule() {
    return function(sb){
        var $overlayContainer   = {},
        $overlayMessageContainer = {},
            emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator;
            
            
        var _init = function() {
            _hide();
        };
        
        
        jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[A-Za-zА-Яа-я]+$/i.test(value);
        }, "Вводите только буквы"); 


        var _assignValidator = function(e) {
            _validator = $($overlayContainer).find('form#order_form').validate({
                    rules: {
                        name_payer: {
                            required: true,
                            minlength: 3
                        },
                        name_recipient: {
                            required: true,
                            minlength: 3
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        phone: {
                            required: true,
                            number: true
                        },
                        city: {
                            required: true,
                            minlength: 3,
                            lettersonly: true
                        }
                    },
                    messages: {
                        name_payer: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        name_recipient: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        email: {
                            required: emptyFieldMess,
                            email: "Введите email в допустимом формате"
                        },
                        phone: {
                            required: emptyFieldMess,
                            number: "Вводите только цифры"
                        },
                        city: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        }
                    }
                });
        };
        
        
        var _show = function() {
            sb.$self().fadeIn();
        };


        var _hide = function(cb) {
            sb.$self().fadeOut(cb);
        };
        
        
        var _onOrderContainerShow = function(){
            var params = {el : '#' + sb.$self().attr('id')};
            $('p#message-success').remove();
            $('form#order_form:hidden').css('display', 'block');
            $overlayContainer = sb.UI.showOverlay(params);
            $($overlayContainer).find('#loader').remove();
            _assignValidator();
        };
                
        
        var _onClickReset = function(){
            sb.publish({
                type : 'on-click-reset',
                data : {overlay : $($overlayContainer)}
            });         
        };
                
                
        var _onClickClose = function(){
            $($overlayContainer).find('p.error-message').remove();
          
            sb.publish({ 
                type : 'on-click-reset' ,
                data : {overlay : $($overlayContainer)}
            });
            $('#'+sb.$self().attr('id')).overlay().close();
        };
                
        
        var _makeOrderItemArr   = function(){
            var $formContainer  = $($overlayContainer).find('form#order_form'),
                productsArr     = {},
                orderItemArr    = {},
                isNotDisabled   = false;
                                
            $('input.quantity:not(:disabled)', $formContainer).each(function(i, item) {
                if($(item).val() != 0){
                    isNotDisabled  = true;
                    productsArr[i] = {  parent_name     : $(item).data('parenttitle'),
                                        product_name    : $(item).data('producttitle'),
                                        property_type   : $(item).data('propertytype'),
                                        amount          : $(item).val() };
                }
            });
           
            if(isNotDisabled){
                orderItemArr    = { name_payer      : $('input[name=name_payer]', $formContainer).val(),
                                    name_recipient  : $('input[name=name_recipient]', $formContainer).val(),
                                    email           : $('input[name=email]', $formContainer).val(),
                                    phone           : $('input[name=phone]', $formContainer).val(),
                                    city            : $('input[name=city]', $formContainer).val(),
//                                    delivery_method : $('input[name=delivery]:checked', $formContainer).val(),
                                    comment         : $('textarea[name=text]', $formContainer).val(),
                                    products_arr    : productsArr };
                return orderItemArr;                                 
            } else {
                throw "Внимание! Для оформления заказа необходимо указать тип продукции и его количество";
            }
        };
        
        
        var _tryLoadOrder = function(orderItemArr){
            $($overlayContainer).find('#order-button-panel').fadeOut('fast').before($('#loader').fadeIn());
            sb.Order.load(orderItemArr,  function(data){
                                            sb.publish({ 
                                                type : 'on-click-reset' ,
                                                data : {overlay : $($overlayContainer)}
                                            });
                                            var orderMessage = '<p id="message-success">Ваш заказ принят! В ближайшее время с вами свяжется представитель компании для уточнения информации по Вашему заказу</p>';
                                            $('form#order_form').css('display','none');
                                            $('#wrap-order h1').after(orderMessage);
                                            $($overlayContainer).find('#loader').fadeOut();
                                            $($overlayContainer).find('#order-button-panel').fadeIn();
                                        }
                                        , function(mess){
                                            $($overlayContainer).find('#loader').fadeOut();
                                            $($overlayContainer).find('#order-button-panel').fadeIn();
                                            alert(mess);
                                        }
            );
        };

        
        var _onClickSubmit = function(e){
            try{
                if($($overlayContainer).find('form#order_form').valid()){
                    _tryLoadOrder(_makeOrderItemArr());
                } 
            } catch(errMess){
                alert(errMess);
            }
            return false;
        };
        
        
        var _bindEvents = function() {  
            sb.$('input[name=reset_order]').live('click', _onClickReset);
            sb.$('input[name=close_order]').live('click', _onClickClose);
            sb.$('input[name=place_order]').live('click', _onClickSubmit);
        };
        
        return {
            init : function(){
                _init();
                sb.subscribe({
                    'order-container-show'  : _onOrderContainerShow,
                    'on-click-close'        : _onClickClose
                });
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}