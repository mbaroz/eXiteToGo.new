ws_blinds=function(options){var $=jQuery;var $IMGs;var parts=[];var prevIndex=0;var $partscont;this.init=function(aCont){var cnt=3;var $container=$(aCont);$IMGs=$("a",$container).find("img");$IMGs.each(function(index){if(index){$(this).hide();}});$partscont=$("<div></div>");$partscont.css({position:"absolute",width:options.width+"px",height:options.height+"px",left:(options.outWidth-options.width)/2+"px",top:(options.outHeight-options.height)/2+"px"});$container.append($partscont);for(var i=0;i<cnt;i++){parts[i]=$("<div></div>");}$(parts).each(function(index){$(this).css({position:"absolute",'background-repeat':"no-repeat",height:"100%",border:"none",margin:0,top:0,left:Math.round(100/cnt)*index+"%",width:(index<cnt-1?Math.round(100/cnt):100-Math.round(100/cnt)*(cnt-1))+"%"});$partscont.append(this);$partscont.hide();});};this.go=function(index){for(var i=0;i<parts.length;i++){parts[i].stop(true,true);}var dir=prevIndex>index?1:0;prevIndex=index;function startPart(part_i,func){var $part=parts[part_i];var w=$part.width();var img=$IMGs.get(index);$part.css({'background-position':(!dir?-$(img).width():$(img).width()-$part.position().left)+"px 0",'background-image':"url("+img.src+")"});$part.animate({'background-position':-$part.position().left+"px 0"},options.duration/(parts.length+1)*(dir?parts.length-part_i+1:part_i+2),func);}function applyImage(){$IMGs.hide();$($IMGs.get(index)).show();$partscont.hide();$(parts).each(function(){$(this).css({'background-image':"none"});});}$partscont.show();for(var i=0;i<parts.length;i++){startPart(i,!dir&&i==parts.length-1||dir&&!i?applyImage:null);}return true;};};(function($){var $div=$("<div style=\"background-position: 3px 5px\">");$.support.backgroundPosition=$div.css("backgroundPosition")==="3px 5px"?true:false;$.support.backgroundPositionXY=$div.css("backgroundPositionX")==="3px"?true:false;$div=null;var xy=["X","Y"];function parseBgPos(bgPos){var parts=bgPos.split(/\s/),values={X:parts[0],Y:parts[1]};return values;}if(!$.support.backgroundPosition&&$.support.backgroundPositionXY){$.cssHooks.backgroundPosition={get:function(elem,computed,extra){return $.map(xy,function(l,i){return $.css(elem,"backgroundPosition"+l);}).join(" ");},set:function(elem,value){$.each(xy,function(i,l){var values=parseBgPos(value);elem.style["backgroundPosition"+l]=values[l];});}};}if($.support.backgroundPosition&&!$.support.backgroundPositionXY){$.each(xy,function(i,l){$.cssHooks["backgroundPosition"+l]={get:function(elem,computed,extra){var values=parseBgPos($.css(elem,"backgroundPosition"));return values[l];},set:function(elem,value){var values=parseBgPos($.css(elem,"backgroundPosition")),isX=l==="X";elem.style.backgroundPosition=(isX?value:values.X)+" "+(isX?values.Y:value);}};$.fx.step["backgroundPosition"+l]=function(fx){$.cssHooks["backgroundPosition"+l].set(fx.elem,fx.now+fx.unit);};});}})(jQuery);

ws_blast=function(options){var $=jQuery;options.duration=options.duration||1000;var boxSize=100;var distance=1;var columns=options.columns || 4;var rows=options.rows || 3;var Images=[];var curIdx=0;var partsOut;var partsIn;var $partCont;this.init=function(aCont){Images=$("img",aCont).get();$(Images).each(function(Index){if(!Index){$(this).show();}else{$(this).hide();}});$(aCont).css({overflow:"visible"});$partCont=$("<div></div>");aCont.append($partCont);$partCont.css({position:"absolute",left:(options.outWidth-options.width)/2+"px",top:(options.outHeight-options.height)/2+"px",width:options.width+"px",height:options.height+"px"});partsOut=[];partsIn=[];for(var index=0;index<columns*rows;index++){var i=index%columns;var j=Math.floor(index/columns);var left0=Math.round(options.width*i/columns);var top0=Math.round(options.height*j/rows);var left1=Math.round(options.width*(i+1)/columns);var top1=Math.round(options.height*(j+1)/rows);$([partsIn[index]=document.createElement("div"),partsOut[index]=document.createElement("div")]).css({position:"absolute",width:left1-left0,height:top1-top0,'background-position':-left0+"px -"+top0+"px"}).appendTo($partCont);}partsOut=$(partsOut);partsIn=$(partsIn);setPos(partsOut);setPos(partsIn,true);};function setPos(parts,random,animate){var pWidth=options.width/columns;var pHeight=options.width/rows;var wpos={left:$(window).scrollLeft(),top:$(window).scrollTop(),width:$(window).width(),height:$(window).height()};$(parts).each(function(index){if(random){var left0=distance*options.width*(2*Math.random()-1)+options.width/2;var top0=distance*options.height*(2*Math.random()-1)+options.height/2;var gpos=$partCont.offset();gpos.left+=left0;gpos.top+=top0;if(gpos.left<wpos.left){left0-=gpos.left+wpos.left;}if(gpos.top<wpos.top){top0-=gpos.top+wpos.top;}if(gpos.left>wpos.left+wpos.width-pWidth){left0-=gpos.left-(wpos.left+wpos.width)+pWidth;}if(gpos.top>wpos.top+wpos.height-pHeight){top0-=gpos.top-(wpos.top+wpos.height)+pHeight;}}else{var left0=Math.round(options.width*(index%columns)/columns);var top0=Math.round(options.height*Math.floor(index/columns)/rows);}if(animate){$(this).animate({left:left0,top:top0},{queue:false,duration:options.duration});}else{$(this).css({left:left0,top:top0});}});}this.go=function(new_index){$partCont.show();$(partsOut).css({opacity:1,'background-image':"url("+$(Images[curIdx]).attr("src")+")"});$(partsIn).css({opacity:0,'background-image':"url("+$(Images[new_index]).attr("src")+")"});setPos(partsIn,false,true);$(partsIn).animate({opacity:1},{queue:false,duration:options.duration,complete:function(){$(Images[curIdx]).hide();}});setPos(partsOut,true,true);$(partsOut).animate({opacity:0},{queue:false,duration:options.duration,complete:function(){$(Images[new_index]).show();for(var i=0;i<Images.length;i++){if(new_index!=i){$(Images[i]).hide();}}$partCont.hide();}});var tmp=partsIn;partsIn=partsOut;partsOut=tmp;curIdx=new_index;return true;};};
function ws_kenburns(options){var $=jQuery;options.duration=options.duration||1000;var paths=[{from:[1,0.8,1],to:[1,0,1.7]},{from:[0,0,1],to:[1,1,1.5]},{from:[1,0.8,1.5],to:[0.8,0,1.1]},{from:[1,0.5,1],to:[0.3,0.5,1.5]}];var Images=[];var curIdx=0;function calcPos(path){var w=options.width;var h=options.height;return{left:-w*(path[2]-1)*path[0],top:-h*(path[2]-1)*path[1],width:w*path[2]+"px"};}this.init=function(aCont){Images=$("img",aCont).get();$(Images).each(function(Index){var $this=$(this);if(!Index){$this.css(calcPos(paths[0].from)).show();$this.animate(calcPos(paths[0].to),{easing:"linear",queue:false,duration:(options.duration+options.delay)*1.5});}else{$this.hide();}});};this.go=function(new_index){$(Images).each(function(Index){var $this=$(this);if(Index==new_index){var path=paths[Index%paths.length];$this.stop(1,1).css(calcPos(path.from));$this.animate(calcPos(path.to),{easing:"linear",queue:false,duration:(options.duration+options.delay)*1.5});$this.fadeIn(options.duration);}if(Index==curIdx){$(this).fadeOut(options.duration);}});curIdx=new_index;return true;};}

jQuery.fn.wowSlider=function(options){var $this=this;var $=jQuery;options=$.extend({effect:function(options){var images;this.init=function(aCont){images=aCont.find("img");images.each(function(Index){if(!Index){$(this).show();}else{$(this).hide();}});};this.go=function(new_index,curIdx){$(images.get(new_index)).fadeIn(options.duration);$(images.get(curIdx)).fadeOut(options.duration);return true;};},prev:"",next:"",duration:1000,delay:2000,outWidth:960,outHeight:360,width:960,height:360,caption:true,controls:true,autoPlay:true,bullets:true,onStep:function(){},stopOnHover:0},options);var $Elements=$this.find(".ws_images A");var images=$Elements.find("IMG");$Elements.each(function(index){var inner=$(this).html()||"";var pos=inner.indexOf(">",inner);if(pos>=0){$(this).data("descr",inner.substr(pos+1));if(pos<inner.length-1){$(this).html(inner.substr(0,pos+1));}}$(this).css({'font-size':0});});var elementsCount=$Elements.length;var frame=$("A.ws_frame",$this).get(0);var curIdx=0;function go(index){if(curIdx==index){return;}var current=effect.go(index,curIdx);if(!current){return;}if(typeof current!="object"){current=$Elements[index];}curIdx=index;go2(index);if(options.caption){setTitle(current);}options.onStep(curIdx);}function go2(index){if(options.bullets){setBullet(index);}if(frame){frame.setAttribute("href",$Elements.get(index).href);}}var autoPlayTimer;function restartPlay(){stopPlay();if(options.autoPlay){autoPlayTimer=setTimeout(function(){go(curIdx<elementsCount-1?curIdx+1:0);restartPlay();},options.delay+options.duration);}}function stopPlay(){if(autoPlayTimer){clearTimeout(autoPlayTimer);}autoPlayTimer=null;}function forceGo(event,index){stopPlay();event.preventDefault();go(index);restartPlay();}$Elements.find("IMG").css("position","absolute");if(typeof options.effect=="string"){options.effect=window["ws_"+options.effect];}var effect=new options.effect(options,$this);effect.init($(".ws_images",$this));$Elements.find("IMG").css("visibility","visible");var ic=c=$(".ws_images",$this);var t="";c=t?$("<div></div>"):0;if(c){c.css({position:"absolute",right:"2px",bottom:"2px",padding:"0 0 0 0"});ic.append(c);}if(c&&document.all){var f=$("<iframe src=\"javascript:false\"></iframe>");f.css({position:"absolute",left:0,top:0,width:"100%",height:"100%",filter:"alpha(opacity=0)"});f.attr({scrolling:"no",framespacing:0,border:0,frameBorder:"no"});c.append(f);}var d=c?$(document.createElement("A")):c;if(d){d.css({position:"relative",display:"block",'background-color':"#E4EFEB",color:"#837F80",'font-family':"Lucida Grande,sans-serif",'font-size':"11px",'font-weight':"normal",'font-style':"normal",'-moz-border-radius':"5px",'border-radius':"5px",padding:"1px 5px",width:"auto",height:"auto",margin:"0 0 0 0",outline:"none"});d.attr({href:"ht"+"tp://"+t.toLowerCase()});d.html(t);d.bind("contextmenu",function(eventObject){return false;});c.append(d);}if(options.controls){var $next_photo=$("<a href=\"#\" class=\"ws_next\">"+options.next+"</a>");var $prev_photo=$("<a href=\"#\" class=\"ws_prev\">"+options.prev+"</a>");$this.append($next_photo);$this.append($prev_photo);$next_photo.bind("click",function(e){forceGo(e,curIdx<elementsCount-1?curIdx+1:0);});$prev_photo.bind("click",function(e){forceGo(e,curIdx>0?curIdx-1:elementsCount-1);});}function initBullets(){$bullets_cont=$this.find(".ws_bullets>div");$bullets=$("a",$bullets_cont);$bullets.click(function(e){forceGo(e,$(e.target).index());});$thumbs=$bullets.find("IMG");if($thumbs.length){var mainFrame=$("<div class=\"ws_bulframe\"/>").appendTo($bullets_cont);var imgContainer=$("<div/>").css({width:$thumbs.length+1+"00%"}).appendTo($("<div/>").appendTo(mainFrame));$thumbs.appendTo(imgContainer);$("<span/>").appendTo(mainFrame);var curIndex=-1;function moveTooltip(index){if(index<0){index=0;}$($bullets.get(curIndex)).removeClass("ws_overbull");$($bullets.get(index)).addClass("ws_overbull");mainFrame.show();var mainCSS={left:$bullets.get(index).offsetLeft-mainFrame.width()/2};var contCSS={left:-$thumbs.get(index).offsetLeft};if(curIndex<0){mainFrame.css(mainCSS);imgContainer.css(contCSS);}else{if(!document.all){mainCSS.opacity=1;}mainFrame.stop().animate(mainCSS,"fast");imgContainer.stop().animate(contCSS,"fast");}curIndex=index;}$bullets.hover(function(){moveTooltip($(this).index());});var hideTime;$bullets_cont.hover(function(){if(hideTime){clearTimeout(hideTime);hideTime=0;}moveTooltip(curIndex);},function(){$bullets.removeClass("ws_overbull");if(document.all){if(!hideTime){hideTime=setTimeout(function(){mainFrame.hide();hideTime=0;},400);}}else{mainFrame.stop().animate({opacity:0},{duration:"fast",complete:function(){mainFrame.hide();}});}});$bullets_cont.click(function(e){forceGo(e,$(e.target).index());});}}function setBullet(new_index){$(".ws_bullets A",$this).each(function(index){if(index==new_index){$(this).addClass("ws_selbull");}else{$(this).removeClass("ws_selbull");}});}if(options.caption){$caption=$("<div class='ws-title' style='display:none'></div>");$this.append($caption);$caption.bind("mouseover",function(e){stopPlay();});$caption.bind("mouseout",function(e){restartPlay();});}function setTitle(A){var title=$("img",A).attr("title");var descr=$(A).data("descr");var $Title=$(".ws-title",$this);$Title.hide();if(title||descr){$Title.html((title?"<span>"+title+"</span>":"")+(descr?"<div>"+descr+"</div>":""));$Title.fadeIn(400,function(){if($.browser.msie){$(this).get(0).style.removeAttribute("filter");}});}}if(options.bullets){initBullets();}go2(0);if(options.caption){setTitle($Elements[0]);}if(options.stopOnHover){this.bind("mouseover",function(e){stopPlay();});this.bind("mouseout",function(e){restartPlay();});}restartPlay();return this;};
