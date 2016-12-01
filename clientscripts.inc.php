<script language="javascript">
function SetCookie(cookieName,cookieValue,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)
                 + ";expires="+expire.toGMTString();
}
var overDIV=document.getElementById("overlayBG");;
function DimBg(d_id) {
//  	hideSelectBoxes();
	overDIV.style.display="";
}
function ElementShow(action,el) {
	if (action=="hide") {
		document.getElementById(el).style.display="none";
		document.getElementById(el).style.visibilty="hidden";
	}
	else {
		document.getElementById(el).style.display="";
		document.getElementById(el).style.visibilty="visible";
	}
}
function ShowLayer(d_id,st,dimbg,showtop) {
  	var d=document.getElementById(d_id);
  	var arrayScroll=getPageScroll();	
  	arrayPageSize = getPageSize();
	Element.setHeight('overlayBG', arrayPageSize[1]);
	//Element.setWidth('overlayBG', arrayPageSize[0]);
	if (showtop==1) Element.setTop(d_id,arrayScroll[1]+35);
  	if (st) {
  		$(d_id).show();
  		if (dimbg) DimBg(d_id);
  	}
  	else {
  		$(d_id).hide();
  		if (dimbg) $(overDIV).hide();;
  	}
}
function switchAdminMode() {
	ShowLayer("AdminModeAlert",1,1);
}
function checkAdminModeSet(f) {
	var AdminModeSet;
	if (f.AdminModeSet[0].checked==false && f.AdminModeSet[1].checked==false) {
		alert ("יש לבחור מצב עבודה");
		return false;
	}
	else {
		if (f.AdminModeSet[1].checked==true) AdminModeSet=0;
		else AdminModeSet=1;
	}
	SetCookie("AdminModeSaved",AdminModeSet,3);
	return true;
}
</script>