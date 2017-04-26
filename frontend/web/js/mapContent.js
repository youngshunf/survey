var infoWindow = null;
var mapServer =  getBasePath() + "/Libary/";
//var mapServer = "http://www.tohow.cn/map/";

//Beijing: 39.92,116.46
//Dalian: 38.92,121.62

var mapArray = [];
var boundsArray = [];
var mapCanvasArray = [];

function getMapIndex(mapDivId){
	for(var i = 0;i<mapCanvasArray.length;i++){
		if(mapCanvasArray[i] == mapDivId)
			return i;
	}
	return -1;
}

function initMap(mapDivId,lat,lng){	
	var mapIndex = getMapIndex(mapDivId);
	if(mapIndex >=0 && mapIndex < mapArray.length){
		return mapArray[mapIndex];
	}
	mapIndex = mapArray.length;

   var mapOptions = {
      center: new google.maps.LatLng(lat,lng),
      zoom: 6,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
   };
 
   var mapTemp = new google.maps.Map(document.getElementById(mapDivId),mapOptions);
   


   

   mapArray[mapIndex] = mapTemp;
   boundsArray[mapIndex] = new google.maps.LatLngBounds();
   mapCanvasArray[mapIndex] = mapDivId;
   
 //  mapTemp.setCenter(new google.maps.LatLng(lat,lng));
   
   if(infoWindow == null)
	   infoWindow = new google.maps.InfoWindow();
   
   return mapTemp;
}
//google.maps.event.adDomListener(window,'load',initialize);


function getBasePath() {
    var curWwwPath = window.document.location.href;
    var pathName = window.document.location.pathname;
    var pos = curWwwPath.indexOf(pathName);
    var localhostPath = curWwwPath.substring(0, pos);
    var projectName = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
    //projectName 
//  return (localhostPath+projectName);
  
  var url=window.location.href;
  var f=new Array();
  
  
  //var loc = url.substring(url.lastIndexOf('.php')+5, url.length);
  //alert(loc);
  var loc = url.split("/");
  if(loc[3] != 'index.php')
  {
	return (localhostPath + projectName);  
  }else {
	return (localhostPath);
  }  
}