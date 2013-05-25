/* ------------------------------------------------------------------------
	Class: prettyPhoto
	Use: Lightbox clone for jQuery
	Author: Stephane Caron (http://www.no-margin-for-errors.com)
	Version: 2.2.6
------------------------------------------------------------------------- */

(function(A){A.fn.prettyPhoto=function(P){var M=0;var D=true;var K=[];var C=0;A(window).scroll(function(){B();});A(window).resize(function(){B();N();});A(document).keyup(function(T){switch(T.keyCode){case 37:if(C==1){return ;}J("previous");break;case 39:if(C==setCount){return ;}J("next");break;case 27:I();break;}});P=jQuery.extend({animationSpeed:"normal",padding:40,opacity:0.35,showAlt:true,allowresize:true,counter_separator_label:"/",theme:"light_rounded"},P);A(this).each(function(){var V=false;var U=false;var W=0;var T=0;K[K.length]=this;A(this).bind("click",function(){G(this);return false;});});function G(T){M=A(T);theRel=A(M).attr("rel");galleryRegExp=/\[(?:.*)\]/;theGallery=galleryRegExp.exec(theRel);isSet=false;setCount=0;for(i=0;i<K.length;i++){if(A(K[i]).attr("rel").indexOf(theGallery)!=-1){setCount++;if(setCount>1){isSet=true;}if(A(K[i]).attr("href")==A(T).attr("href")){C=setCount;arrayPosition=i;}}}Q(isSet);A("div.pp_pic_holder p.currentTextHolder").text(C+P.counter_separator_label+setCount);B();A("div.pp_pic_holder #full_res").hide();A(".pp_loaderIcon").show();R();}showimage=function(W,T,Z,Y,X,U,V){A(".pp_loaderIcon").hide();var a=F();if(A.browser.opera){windowHeight=window.innerHeight;windowWidth=window.innerWidth;}else{windowHeight=A(window).height();windowWidth=A(window).width();}A("div.pp_pic_holder .pp_content").animate({height:X,width:Z},P.animationSpeed);projectedTop=a.scrollTop+((windowHeight/2)-(Y/2));if(projectedTop<0){projectedTop=0+A("div.ppt").height();}A("div.pp_pic_holder").animate({top:projectedTop,left:((windowWidth/2)-(Z/2)),width:Z},P.animationSpeed,function(){A("#fullResImage").attr({width:W,height:T});A("div.pp_pic_holder").width(Z);A("div.pp_pic_holder .hoverContainer").height(T).width(W);A("div.pp_pic_holder #full_res").fadeIn(P.animationSpeed);E();if(V){A("a.pp_expand,a.pp_contract").fadeIn(P.animationSpeed);}});};function J(T){if(T=="previous"){arrayPosition--;C--;}else{arrayPosition++;C++;}if(!D){D=true;}A("div.pp_pic_holder .hoverContainer,div.pp_pic_holder .pp_details").fadeOut(P.animationSpeed);A("div.pp_pic_holder #full_res").fadeOut(P.animationSpeed,function(){A(".pp_loaderIcon").show();R();});S();A("a.pp_expand,a.pp_contract").fadeOut(P.animationSpeed,function(){A(this).removeClass("pp_contract").addClass("pp_expand");});}function I(){A("div.pp_pic_holder,div.ppt").fadeOut(P.animationSpeed,function(){A("div.pp_overlay").fadeOut(P.animationSpeed,function(){A("div.pp_overlay,div.pp_pic_holder,div.ppt").remove();if(A.browser.msie&&A.browser.version==6){A("select").css("visibility","visible");}});});D=true;}function H(){if(C==setCount){A("div.pp_pic_holder a.pp_next").css("visibility","hidden");A("div.pp_pic_holder a.pp_arrow_next").addClass("disabled").unbind("click");}else{A("div.pp_pic_holder a.pp_next").css("visibility","visible");A("div.pp_pic_holder a.pp_arrow_next.disabled").removeClass("disabled").bind("click",function(){J("next");return false;});}if(C==1){A("div.pp_pic_holder a.pp_previous").css("visibility","hidden");A("div.pp_pic_holder a.pp_arrow_previous").addClass("disabled").unbind("click");}else{A("div.pp_pic_holder a.pp_previous").css("visibility","visible");A("div.pp_pic_holder a.pp_arrow_previous.disabled").removeClass("disabled").bind("click",function(){J("previous");return false;});}A("div.pp_pic_holder p.currentTextHolder").text(C+P.counter_separator_label+setCount);var T=(isSet)?A(K[arrayPosition]):A(M);if(T.attr("alt")){A("div.pp_pic_holder .pp_description").show().html(unescape(T.attr("alt")));}else{A("div.pp_pic_holder .pp_description").hide().text("");}if(T.find("img").attr("alt")&&P.showAlt){hasAlt=true;A("div.ppt .ppt_content").html(unescape(T.find("img").attr("alt")));}else{hasAlt=false;}}function L(U,T){hasBeenResized=false;A("div.pp_pic_holder .pp_details").width(U);A("div.pp_pic_holder .pp_details p.pp_description").width(U-parseFloat(A("div.pp_pic_holder a.pp_close").css("width")));contentHeight=T+parseFloat(A("div.pp_pic_holder .pp_details").height())+parseFloat(A("div.pp_pic_holder .pp_details").css("margin-top"))+parseFloat(A("div.pp_pic_holder .pp_details").css("margin-bottom"));contentWidth=U;containerHeight=T+parseFloat(A("div.ppt").height())+parseFloat(A("div.pp_pic_holder .pp_top").height())+parseFloat(A("div.pp_pic_holder .pp_bottom").height());containerWidth=U+P.padding;imageWidth=U;imageHeight=T;windowHeight=A(window).height();windowWidth=A(window).width();if(((containerWidth>windowWidth)||(containerHeight>windowHeight))&&D&&P.allowresize){hasBeenResized=true;notFitting=true;while(notFitting){if((containerWidth>windowWidth)){imageWidth=(windowWidth-200);imageHeight=(T/U)*imageWidth;}else{if((containerHeight>windowHeight)){imageHeight=(windowHeight-200);imageWidth=(U/T)*imageHeight;}else{notFitting=false;}}containerHeight=imageHeight;containerWidth=imageWidth;}contentHeight=imageHeight+parseFloat(A("div.pp_pic_holder .pp_details").height())+parseFloat(A("div.pp_pic_holder .pp_details").css("margin-top"))+parseFloat(A("div.pp_pic_holder .pp_details").css("margin-bottom"));contentWidth=imageWidth;containerHeight=imageHeight+parseFloat(A("div.ppt").height())+parseFloat(A("div.pp_pic_holder .pp_top").height())+parseFloat(A("div.pp_pic_holder .pp_bottom").height());containerWidth=imageWidth+P.padding;A("div.pp_pic_holder .pp_details").width(contentWidth);A("div.pp_pic_holder .pp_details p.pp_description").width(contentWidth-parseFloat(A("div.pp_pic_holder a.pp_close").css("width")));}return{width:imageWidth,height:imageHeight,containerHeight:containerHeight,containerWidth:containerWidth,contentHeight:contentHeight,contentWidth:contentWidth,resized:hasBeenResized};}function B(){if(A("div.pp_pic_holder").size()>0){var T=F();if(A.browser.opera){windowHeight=window.innerHeight;windowWidth=window.innerWidth;}else{windowHeight=A(window).height();windowWidth=A(window).width();}if(D){projectedTop=(windowHeight/2)+T.scrollTop-(A("div.pp_pic_holder").height()/2);if(projectedTop<0){projectedTop=0+A("div.ppt").height();}A("div.pp_pic_holder").css({top:projectedTop,left:(windowWidth/2)+T.scrollLeft-(A("div.pp_pic_holder").width()/2)});A("div.ppt").css({top:A("div.pp_pic_holder").offset().top-A("div.ppt").height(),left:A("div.pp_pic_holder").offset().left+(P.padding/2)});}}}function E(){if(isSet){A("div.pp_pic_holder .hoverContainer").fadeIn(P.animationSpeed);}A("div.pp_pic_holder .pp_details").fadeIn(P.animationSpeed);O();}function O(){if(P.showAlt&&hasAlt){A("div.ppt").css({top:A("div.pp_pic_holder").offset().top-22,left:A("div.pp_pic_holder").offset().left+(P.padding/2),display:"none"});A("div.ppt div.ppt_content").css("width","auto");if(A("div.ppt").width()>A("div.pp_pic_holder").width()){A("div.ppt div.ppt_content").css("width",A("div.pp_pic_holder").width()-(P.padding*2));}else{A("div.ppt div.ppt_content").css("width","");}A("div.ppt").fadeIn(P.animationSpeed);}}function S(){A("div.ppt").fadeOut(P.animationSpeed);}function R(){H();imgPreloader=new Image();nextImage=new Image();if(isSet&&C>setCount){nextImage.src=A(K[arrayPosition+1]).attr("href");}prevImage=new Image();if(isSet&&K[arrayPosition-1]){prevImage.src=A(K[arrayPosition-1]).attr("href");}A("div.pp_pic_holder .pp_content").css("overflow","hidden");if(isSet){A("div.pp_pic_holder #fullResImage").attr("src",A(K[arrayPosition]).attr("href"));}else{A("div.pp_pic_holder #fullResImage").attr("src",A(M).attr("href"));}imgPreloader.onload=function(){var T=L(imgPreloader.width,imgPreloader.height);imgPreloader.width=T.width;imgPreloader.height=T.height;setTimeout("showimage(imgPreloader.width,imgPreloader.height,"+T.containerWidth+","+T.containerHeight+","+T.contentHeight+","+T.contentWidth+","+T.resized+")",500);};(isSet)?imgPreloader.src=A(K[arrayPosition]).attr("href"):imgPreloader.src=A(M).attr("href");}function F(){scrollTop=window.pageYOffset||document.documentElement.scrollTop||0;scrollLeft=window.pageXOffset||document.documentElement.scrollLeft||0;return{scrollTop:scrollTop,scrollLeft:scrollLeft};}function N(){A("div.pp_overlay").css({height:A(document).height(),width:A(window).width()});}function Q(){backgroundDiv="<div class='pp_overlay'></div>";A("body").append(backgroundDiv);A("div.pp_overlay").css("height",A(document).height()).bind("click",function(){I();});pictureHolder='<div class="pp_pic_holder"><div class="pp_top"><div class="pp_left"></div><div class="pp_middle"></div><div class="pp_right"></div></div><div class="pp_content"><a href="#" class="pp_expand" title="Expand the image">Expand</a><div class="pp_loaderIcon"></div><div class="hoverContainer"><a class="pp_next" href="#">next</a><a class="pp_previous" href="#">previous</a></div><div id="full_res"><img id="fullResImage" src="" /></div><div class="pp_details clearfix"><a class="pp_close" href="#">Close</a><p class="pp_description"></p><div class="pp_nav"><a href="#" class="pp_arrow_previous">Previous</a><p class="currentTextHolder">0'+P.counter_separator_label+'0</p><a href="#" class="pp_arrow_next">Next</a></div></div></div><div class="pp_bottom"><div class="pp_left"></div><div class="pp_middle"></div><div class="pp_right"></div></div></div>';altHolder='<div class="ppt"><div class="ppt_left"></div><div class="ppt_content"></div><div class="ppt_right"></div></div>';A("body").append(pictureHolder).append(altHolder);A(".pp_pic_holder,.altHolder").css({opacity:0});A(".pp_pic_holder,.ppt").addClass(P.theme);A("a.pp_close").bind("click",function(){I();return false;});A("a.pp_expand").bind("click",function(){if(A(this).hasClass("pp_expand")){A(this).removeClass("pp_expand").addClass("pp_contract");D=false;}else{A(this).removeClass("pp_contract").addClass("pp_expand");D=true;}S();A("div.pp_pic_holder .hoverContainer,div.pp_pic_holder #full_res").fadeOut(P.animationSpeed);A("div.pp_pic_holder .pp_details").fadeOut(P.animationSpeed,function(){R();});return false;});A(".pp_pic_holder .pp_previous,.pp_pic_holder .pp_arrow_previous").bind("click",function(){J("previous");return false;});A(".pp_pic_holder .pp_next,.pp_pic_holder .pp_arrow_next").bind("click",function(){J("next");return false;});A(".hoverContainer").css({"margin-left":P.padding/2});if(!isSet){A(".hoverContainer,.pp_nav").hide();}if(A.browser.msie&&A.browser.version==6){A("body").addClass("ie6");A("select").css("visibility","hidden");}A("div.pp_overlay").css("opacity",0).fadeTo(P.animationSpeed,P.opacity,function(){A("div.pp_pic_holder").css("opacity",0).fadeIn(P.animationSpeed,function(){A("div.pp_pic_holder").attr("style","left:"+A("div.pp_pic_holder").css("left")+";top:"+A("div.pp_pic_holder").css("top")+";");});});}};})(jQuery);
