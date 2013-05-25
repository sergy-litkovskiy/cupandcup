function MenuEditContainerModule() {
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
        
        
        var _trySubmit = function(data){
            var _currentForm = data.currentForm;

            var formData = {id                  : $('input[name=id]', _currentForm).val(),
                            title               : $('input[name=title]', _currentForm).val(),
                            slug                : $('input[name=slug]', _currentForm).val(),
                            num_sequence        : $('input[name=id]', _currentForm).val(),
                            status              : $('input[name=status]', _currentForm).val(),
                            seo_title           : $('input[name=seo_title]', _currentForm).val(),
                            seo_description     : $('textarea[name=seo_description]', _currentForm).val(),
                            seo_keywords        : $('textarea[name=seo_keywords]', _currentForm).val(),
                            description         : tinyMCE.activeEditor.getContent()
            };
            sb.Menu.addOrUpdate(formData, _onSuccess, _onError);
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
        
        
        var _onClickProcess = function(e){
            _hideAllForms();
            var elementId = $(_menuEditContainer).find('textarea.edit_detail_full').attr('id');
       
            sb.publish({
                type : 'init-advanced-mce-for-element',
                data : elementId
            });
           
            $(_menuEditContainer).fadeIn(                    
                    sb.publish({
                        type : 'hide-the-form'
                    }));
                    
            _assignValidator();
            
            $(_menuEditContainer).find('input.button_submit').click(_onClickSubmit);
        };
        
        
        var _onClickEditDetail = function(e){
            e.preventDefault();
            _menuEditContainer = $(this).parent().parent().next($('div.main_menu_edit'));
            _onClickProcess();
        };
        
        
        var _tryDeleteMenuItem = function(_menuItemId){
            sb.Menu.deleteMenuItem(_menuItemId, _onSuccess, _onError);
        }
        
        
        var _onClickDeleteItemMenu = function(e){
            e.preventDefault();
            var _menuItemId = $(this).parent().parent().attr('id');
            sb.UI.showDialog({
                    yes          : function(){ _tryDeleteMenuItem(_menuItemId)}
                  , message : '<p class="error">Вы уверены, что хотите удалить этот раздел?</p>'
                });
        };
        
                
        var _onClickChangeStatusItemMenu = function(e){
            e.preventDefault();
            var _currentForm = $(this).parent(),
                _selectedVal = $(this).val();
                _currentForm.find('input').removeProp('checked');
                _currentForm.find('input[value='+_selectedVal+']').prop('checked');
                
            var _data = {
                menuItemId : $(this).parent().parent().attr('id'),
                itemStatus : $(this).val()
            };
             
            sb.Menu.changeStatusMenuItem(_data, _onSuccess, _onError);
        };
        
        
        var _onClickMoveUpItemMenu = function(e){
            e.preventDefault();
            var _prevPositionArr    = [],
                _currentPosition    = $(this).parent().parent().data('position'),
                _prevIdPosition     = $(this).parent().parent().data('prev-id-position');
                _prevPositionArr    = _prevIdPosition == 0 ? 0 : _prevIdPosition.split('|');
 
            if(typeof _prevPositionArr == 'object'){
                var _data = {
                    currMenuItemId      : $(this).parent().parent().attr('id'),
                    currNumSequence     : _prevPositionArr[1],
                    besideMenuItemId    : _prevPositionArr[0],
                    besideNumSequence   : _currentPosition
                };
             
                sb.Menu.changePositionMenuItem(_data, _onSuccess, _onError);
            }
        };
        
        
        var _onClickMoveDownItemMenu = function(e){
            e.preventDefault();
            var _nextPositionArr    = [],
                _currentPosition    = $(this).parent().parent().data('position'),
                _nextIdPosition     = $(this).parent().parent().data('next-id-position');
                _nextPositionArr    = _nextIdPosition == 0 ? 0 : _nextIdPosition.split('|');

            if(typeof _nextPositionArr == 'object'){
                var _data = {
                    currMenuItemId      : $(this).parent().parent().attr('id'),
                    currNumSequence     : _nextPositionArr[1],
                    besideMenuItemId    : _nextPositionArr[0],
                    besideNumSequence   : _currentPosition
                };
             
                sb.Menu.changePositionMenuItem(_data, _onSuccess, _onError);
            }
        };
        
        
        var _bindEvents = function() {  
            sb.bind('div.main_item > form.edit_panel > a.edit', 'click', _onClickEditDetail);
            sb.bind('div.main_item > form.edit_panel > a.delete', 'click', _onClickDeleteItemMenu);
            sb.bind('div.main_item > form.edit_panel > input.show', 'click', _onClickChangeStatusItemMenu);
            sb.bind('div.main_item > form.edit_panel > input.hide', 'click', _onClickChangeStatusItemMenu);
            sb.bind('div.main_item > span > a.arrow_up', 'click', _onClickMoveUpItemMenu);
            sb.bind('div.main_item > span > a.arrow_down', 'click', _onClickMoveDownItemMenu);
        };
        
        return {
            init : function(){
                _init();
                sb.subscribe({
                    'hide-all-forms'            : _hideAllForms,
                    'on-click-submit'           : _trySubmit
                });
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}