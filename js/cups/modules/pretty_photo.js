function PrettyPhotoModule() {
    return function(sb){
        var _init = function() {
            sb.$("a[rel^='prettyPhoto']").prettyPhoto({
                animationSpeed: 'normal',
                padding: 40,
                opacity: 0.65,
                showTitle: true,
                allowresize: true,
                counter_separator_label: '/',          
                theme: 'light_rounded' 
            });
        };
  
        return {
            init : function(){
                _init();
            },
            destroy : function(){ }
        };
    }
}