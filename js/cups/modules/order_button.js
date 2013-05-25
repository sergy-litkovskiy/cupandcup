function OrderButtonModule() {
    return function(sb){
        var _onClickOrderButton = function(){
            sb.publish({
                type : 'order-container-show'
            });         
        };
        
        
        var _bindEvents = function() {            
            sb.bind('input#button', 'click', _onClickOrderButton);
        };
        
        
        return {
            init : function(){
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}