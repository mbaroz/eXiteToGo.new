function print_exiteDiv(divID) {
        var divToPrint=document.getElementById(divID);
        newWin= window.open("");
        newWin.document.write('<html><head></head><body dir="rtl">'+divToPrint.outerHTML+'</body></html>');
        newWin.print();
        newWin.close();
}
jQuery(document).ready(function() {
    var printAreaName="PrintMeHere";
    jQuery(".leftSide").attr("id",printAreaName);
    jQuery(".print_this").css("cursor","pointer");
    jQuery(".print_this").click(function() {
        print_exiteDiv(printAreaName);
    });
});
