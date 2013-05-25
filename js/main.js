$(document).ready(function(){
////////////////////////////////////////////////////////////////
//cross_slider
    var imgArr = [], i;
    
    var _makeImgUrl = function(i){
        return {src: 'http://' + location.hostname + '/img/imgline/cupslider'+i+'.png'}
    }

    for(i=1; i<=6; i++){
        imgArr.push(_makeImgUrl(i));
    }
   
    $('div.slider').crossSlide({
        sleep: 4,
        fade: 1
        }, imgArr
);   
});                