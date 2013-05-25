function MenuEditContainerNewModule() {
    return function(sb){
        var _menuEditContainer = sb.$('div.main_menu_edit_new'), 
            _validator,
            emptyFieldMess      = 'Заполните поле';
        
        var _show = function(cb) {
            _menuEditContainer.fadeIn(cb);
        };


        var _hide = function() {
            _menuEditContainer.fadeOut();
        };
        
        
        var _makeEmptyFormFields = function() {
            sb.$('form input[type=text],textarea').val('');
        };
        
        
        var _init = function() {
            _makeEmptyFormFields();
            sb.$('.main_menu_edit_new').hide();
        };
                
                
        var _assignValidator = function(e) {
            _validator = $(_menuEditContainer).find('form').validate({
                    rules: {
                        title: {
                            required: true
                        },
                        slug: {
                            required: true
                        }
                    },
                    messages: {
                        title: {
                            required: emptyFieldMess
                        },
                        slug: {
                            required: emptyFieldMess
                        }
                    }
                });
        };
               

        var _onClickSubmit = function(e){
            e.preventDefault();
            var $currentForm = $(_menuEditContainer).find('form');
           
            if($currentForm.valid()){
                sb.publish({
                    type : 'on-click-submit',
                    data : {currentForm : $currentForm}
                });
            }
        };


        var _onClickEditNewFormDetail = function(e){
            e.preventDefault();
           
            if(_menuEditContainer.is(':visible')){
                _hide();
            } else {
                var elementId = $(_menuEditContainer).find('textarea.edit_detail_full').attr('id');
                _show(function(){
                    sb.publish({
                        type : 'hide-all-forms'
                    });
                    
                    sb.publish({
                        type : 'init-advanced-mce-for-element',
                        data : elementId
                    });
                });
                
                _assignValidator();
                _menuEditContainer.find('input.button_submit').click(_onClickSubmit);
            }
        };
        
        
        var _bindEvents = function() {  
            sb.bind('#add_new', 'click', _onClickEditNewFormDetail);
        };
        
        return {
            init : function(){
                _init();
                _bindEvents();
                sb.subscribe({
                    'hide-the-form'  : _hide
                });
            },
            destroy : function(){ }
        };
    }
}