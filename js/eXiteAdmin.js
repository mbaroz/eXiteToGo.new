(function ( $ ) {
 
    $.fn.addSetting = function( options ) {
 
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            inputs:''
        }, options );
        var o=JSON.parse(settings.inputs);
        var elementStr=Array();
        var i=0;
        var elementStrHead="<table>";
        var elementStrLine=Array();
        var elementStrEndLine="</td></tr>";
        $.each(o.items,function(){
            elementStrLine[i]="<tr>";
            if (this.element=="") this.element='input';
            if (this.type=="") this.type='text';
            if (!this.defaultValue) this.defaultValue='';
            elementStrLine[i]+"<td>"+this.label+"</td>";
            if (this.element!='input')  elementStr[i]=elementStrLine[i]+'<'+this.element+'></'+this.element+'>'+elementStrEndLine;
            else elementStr[i]=elementStrLine[i]+'<'+this.element+' name="'+this.name+'" type="'+this.type+'" value="'+this.defaultValue+'" />'+elementStrEndLine;
            i++;
        });
        var returnElement=elementStrHead+elementStr+"</table>";
        
        return this.append(returnElement);
           
 
    };
 
}( jQuery ));