function ContactFormModule() {
    return function(sb){
        var $overlayContainer   = {},
        $overlayMessageContainer = {},
            emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator,
            _form = sb.$('#contact_form');
            
            
        var _init = function() {
            sb.$('input').not('input[type=submit]').val('');
            sb.$('#message-success:visible').remove();
        };
        
        
        jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[A-Za-zА-Яа-я]+\s*[A-Za-zА-Яа-я]*$/i.test(value);
        }, "Вводите только буквы"); 


        var _assignValidator = function(e) {
            _validator = _form.validate({
                    rules: {
                        name: {
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
                        name: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        email: {
                            required: emptyFieldMess,
                            email: "Введите email в допустимом формате"
                        },
                        phone: {
                            required: emptyFieldMess,
                            number: "Вводите только цифры<br/>(пример - 80501234567)"
                        },
                        city: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        }
                    }
                });
        };
        
        
        var _makeFormData   = function(){
            return { name   : $('input[name=name]', _form).val(),
                    email   : $('input[name=email]', _form).val(),
                    phone   : $('input[name=phone]', _form).val(),
                    city    : $('input[name=city]', _form).val()
                };
        };
        
        
        var _trySendMail = function(formData){
            sb.$('#button').fadeOut('fast').before(sb.$('#loader').fadeIn());
            sb.Contact.sendMail(formData,  function(data){
                                            var orderMessage = '<p id="message-success">Ваш заказ принят! В ближайшее время с вами свяжется представитель компании для уточнения информации по Вашему заказу</p>';
                                            
                                            sb.$('#loader').fadeOut();
                                            sb.$('#button').fadeIn();
                                            sb.$('form').before(orderMessage);
                                        }
                                        , function(mess){
                                            sb.$('#loader').fadeOut();
                                            sb.$('#button').fadeIn();
                                            alert(mess);
                                        }
            );
        };

        
        var _onClickSubmit = function(e){
            e.preventDefault();
            try{
                if(_form.valid()){
                    _trySendMail(_makeFormData());
                } 
            } catch(errMess){
                alert(errMess);
            }
            return false;
        };
        
        
        var _bindEvents = function() {  
            sb.bind('input[type=submit]','click', _onClickSubmit);
        };
        
        return {
            init : function(){
                _init();
                _assignValidator();
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}