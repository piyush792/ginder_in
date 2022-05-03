var divPopupHolder;
var divPopupHolderHeight;
var divMaskHolder;
var divPopupHolderTop;
var blnPopupMask;
function isIridesse(){
	if (typeof(locale) != "undefined" && locale != ""){
		if (locale.toLowerCase().indexOf("ird") > -1){
			return true;
		}
	}
	return false;
}
function openMarketingPopUp(popUpName){
	var foundPopUp = openMarketingPopUpFollowup(popUpName, arguments);	
}
function createPopUp (pwidth,pheight,blnMask,obj,ptop,href,bColor,blnBorder,mColor,opacity ) {
	divPopupHolderTop = ptop;
	blnPopupMask = blnMask;
	if(blnPopupMask){
			ptop = ptop
	}else{
		ptop = ptop +getPageScrollTop();
	} //getPageScrollTop()
	divPopupHolderHeight = pheight;
	if (blnPopupMask) {pBorderWidth = 0} else {pBorderWidth = 0}
	if (typeof blnBorder == 'undefined'){} else {if(!blnBorder) {pBorderWidth = 0}}

	if (typeof bColor == 'undefined'){if (blnPopupMask) {borderColor = "E2E0DB"} else {borderColor = "E0E0E0"}}
	else {borderColor=bColor}
	var destURL = href
	var isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != -1);true;false;
	
	txtPopUpContent = '<iframe id="iframeContent" name="iframeContent" src="'+href+'" style="border:0; width:'+pwidth+'px; height:'+pheight+'px" frameborder="0" scrolling="no"></iframe>'
	divPopupHolder = document.createElement("div");
	document.body.insertBefore(divPopupHolder, document.body.firstChild);
	divPopupHolder.id = "divPopUp"
	divPopupHolder.className= "divPopUp"
	divPopupHolder.style.position = "absolute";
	divPopupHolder.style.width = pwidth +"px";
	divPopupHolder.style.marginLeft = Math.round((pwidth+(pBorderWidth*2))/2)*-1 + "px"
	divPopupHolder.style.left = "50%";
	divPopupHolder.style.top = ptop +"px";
	divPopupHolder.style.borderWidth = pBorderWidth +"px";
	divPopupHolder.style.borderColor = borderColor
	divPopupHolder.style.borderStyle ="solid"
	divPopupHolder.innerHTML = txtPopUpContent;

	divMaskHeaderHolder = document.createElement("div");
	document.body.insertBefore(divMaskHeaderHolder, document.body.firstChild);
	divMaskHeaderHolder.id = "divMaskHeader"
	if (blnPopupMask) {divMaskHeaderHolder.className= "divHeaderMask"
		if (typeof mColor == 'undefined'){}
		else {divMaskHolder.style.backgroundColor =mColor;}
	}
	else {divMaskHeaderHolder.className= "divClearMask"}
	divMaskHeaderHolder.style.height = "0px"
	divMaskHeaderHolder.style.top = "0px"
	divMaskHeaderHolder.innerHTML = "&nbsp;";
	divMaskHeaderHolder.onclick = closePopUp;

	divMaskHolder = document.createElement("div");
	document.body.insertBefore(divMaskHolder, document.body.firstChild);
	divMaskHolder.id = "divMask"
	if (blnPopupMask) {
		divMaskHolder.className= "divMask";
		if (typeof mColor == 'undefined'){}
		else {
			divMaskHolder.style.backgroundColor =mColor;
		}
	}
	else {divMaskHolder.className= "divClearMask"}
	var pagebtmPad = 25;
	var pagetopPad = 0;
	var headerHeight = 84;
	if (isIridesse()) {
		pagebtmPad = -10;
		pagetopPad = 0;
		headerHeight = 48;
	}
	divMaskHolder.style.height = (getPageHeight() + pagebtmPad - headerHeight) +"px"
	divMaskHolder.style.top = (pagetopPad + headerHeight) +"px"
	divMaskHolder.innerHTML = "&nbsp;";
	divMaskHolder.onclick = closePopUp;

	divMaskFooterHolder = document.createElement("div");
	document.body.insertBefore(divMaskFooterHolder, document.body.firstChild);
	divMaskFooterHolder.id = "divMaskFooter"
	if (blnPopupMask) {
		divMaskFooterHolder.className= "divFooterMask";
	}
	else {divMaskFooterHolder.className= "divClearMask"}	
	divMaskFooterHolder.style.height = "px"
	divMaskFooterHolder.style.top = getPageHeight()+ pagebtmPad +"px"
	divMaskFooterHolder.innerHTML = "&nbsp;";
	divMaskFooterHolder.onclick = closePopUp;

	if (isIE6()){
		divMaskIframeHolder = document.createElement("iframe");
		divMaskIframeHolder.id = "divShimMask";
		divMaskIframeHolder.className = "divShimMask";
		divMaskIframeHolder.src = "images/clr.gif"
		divMaskIframeHolder.scrolling ="no";
		divMaskIframeHolder.frameBorder ="0";
		divMaskIframeHolder.style.width = "972px";
		divMaskIframeHolder.style.height = (getPageHeight() + pagebtmPad) +"px";
		document.body.insertBefore(divMaskIframeHolder, document.body.firstChild);
	}
}
function isIE6() {
	var agt=navigator.userAgent.toLowerCase();
    var appVer = navigator.appVersion.toLowerCase();
    var is_minor = parseFloat(appVer);
    var is_major = parseInt(is_minor);
    var iePos  = appVer.indexOf('msie');
    if (iePos !=-1) {
       is_minor = parseFloat(appVer.substring(iePos+5,appVer.indexOf(';',iePos)));
       is_major = parseInt(is_minor);
    }
	if ((iePos!=-1) && is_major<7) {return true}
	else {return false}
}
function getPageScrollTop(){
	var yScrolltop;
	if (self.pageYOffset ) {
		yScrolltop = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop ){	 // Explorer 6 Strict
		yScrolltop = document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		yScrolltop = document.body.scrollTop;
	}
	if(getPageHeight() - divPopupHolderHeight - yScrolltop -25 < 0) {
		//yScrolltop = yTestScrolltop
	}
	else {yTestScrolltop = yScrolltop}
	return yScrolltop;
}
function closePopUp(){
	if (typeof(divPopupHolder) != "undefined"){
		divPopupHolder.innerHTML = "";
		document.body.removeChild(divPopupHolder);
		divMaskHeaderHolder.innerHTML = "";
		document.body.removeChild(divMaskHeaderHolder);
		divMaskHolder.innerHTML = "";
		document.body.removeChild(divMaskHolder);
		divMaskFooterHolder.innerHTML = "";
		document.body.removeChild(divMaskFooterHolder);
		if (isIE6()) {document.body.removeChild(divMaskIframeHolder);}
		window.onscroll = "";
	}
}
function popup() {
	createPopUp(838,581,false,this,120,'popup.html');
			foundPopUp = false;
}

//function green_guru_schedule() {
//	createPopUp(951,1360,false,this,20,'green_guru_schedule.php');
//			foundPopUp = false;
//}