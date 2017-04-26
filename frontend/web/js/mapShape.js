
//<![CDATA[
//var mapActive = null;
var boundsActive = null;
var shapeObjectList = [];

function clearShapeObjectList(){
//	infoWindow.close();
	for(var i=0;i<shapeObjectList.length;i++)
		shapeObjectList[i].setMap(null);
	shapeObjectList.length = 0;
}

function setActiveMap(mapThis){
	var index = getMapIndexFromMap(mapThis);

	if(index >= 0 ){
		boundsActive = boundsArray[index];
	}
}

function getMapIndexFromMap(map){
	for(var i=0;i<mapArray.length;i++){
		if(map == mapArray[i])
			return i;
	}
	return -1;
}

function createShape(fileName,fieldNameList,shapeType,mapId){
	setActiveMap(mapId);
	
	var urlShape = mapServer+"getShape_genxml.php"+"?f="+fileName+"&a="+fieldNameList;

	downloadUrl(urlShape,function(data){
		var xml = parseXml(data);	
		
		var shapeXmlNodes = xml.documentElement.getElementsByTagName("coords");	

		for (var i = 0; i < shapeXmlNodes.length; i++) {			
			createOneShape(i,shapeXmlNodes,shapeType,fieldNameList,mapId);
		}

	});
}

function parseCoords(pointlist){
	var pointListArray = pointlist.split(";");
	
	shapeObjectListCoords = new Array();
	shapeObjectListCoords.length = pointListArray.length;
	
	for (var i=0;i<pointListArray.length;i++ ){
		var coordPair = new Array();
		coordPair = pointListArray[i].split(",");
		
		shapeObjectListCoords[i] = new google.maps.LatLng(coordPair[1],coordPair[0]);
	}
	
	return shapeObjectListCoords;
}


function createOneShape(i,shapeXmlNode,shapeType,fieldNameList,mapActive){
	var shapeIndex = shapeObjectList.length;

	var pointlist = shapeXmlNode[i].getAttribute("pointlist");			
	var shapeCoords = parseCoords(pointlist);
	
	// Construct the shapeObjectList.
	if(shapeType == "polygon"){
		shapeObjectList[shapeIndex] = new google.maps.Polygon({
			paths: shapeCoords,
			strokeColor: "#ff0000",
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: "#ffee00",
			fillOpacity: 0.35
		});
	}else if(shapeType == "polyline"){
		shapeObjectList[shapeIndex] = new google.maps.Polyline({
			path: shapeCoords,
			strokeColor: "#ff0000",
			strokeOpacity: 0.8,
			strokeWeight: 2
		});
	}else if(shapeType == "point"){
		shapeObjectList[shapeIndex] = new google.maps.Marker({
			position: shapeCoords[0]
		});		
	}

	shapeObjectList[shapeIndex].setMap(mapActive);

	for(var j= 0;j<shapeCoords.length;j++)
		boundsActive.extend(shapeCoords[j]);
	mapActive.fitBounds(boundsActive);
	
	//alert(fieldNameList);
	var html = "";
	
	if(fieldNameList==""){
		html = "Object: " + i;		
	}
	else{
		var fieldNameArray = fieldNameList.split(','); 

		for(var j = 0;j<fieldNameArray.length;j++){
			var fieldValue = shapeXmlNode[i].getAttribute(fieldNameArray[j]);

			htmlTemp =   "<b>" + fieldNameArray[j] + " : " + fieldValue + "</b> <br/>";
			html += htmlTemp;
		}
	}
	
   // Add a listener for the click event
	google.maps.event.addListener(shapeObjectList[shapeIndex], 'click', function(event) {
		infoWindow.setContent(html);
		infoWindow.setPosition(event.latLng);
		infoWindow.open(mapActive);
	});
}


function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request.responseText, request.status);
    }
  };

  request.open('GET', url, true);
  request.send(null);
}

function parseXml(str) {
  if (window.ActiveXObject) {
    var doc = new ActiveXObject('Microsoft.XMLDOM');
    doc.loadXML(str);
    return doc;
  } else if (window.DOMParser) {
    return (new DOMParser).parseFromString(str, 'text/xml');
  }
}

function doNothing(){}


function createColorShape(fileName,fieldNameList,shapeType,mapId,markersArray,colorNum){
	setActiveMap(mapId);
	
	var urlShape = mapServer+"getShape_genxml.php"+"?f="+fileName+"&a="+fieldNameList;
	
	downloadUrl(urlShape,function(data){
		
		var xml = parseXml(data);	

		var shapeXmlNodes = xml.documentElement.getElementsByTagName("coords");	
		
		for (var i = 0; i < shapeXmlNodes.length; i++) {	

			createOneColorShape(i,shapeXmlNodes,shapeType,fieldNameList,mapId,markersArray,colorNum);
		}
		
	});
}

function createOneColorShape(i,shapeXmlNode,shapeType,fieldNameList,mapActive,markersArray,colorNum){
	var shapeIndex = markersArray.length;

	var pointlist = shapeXmlNode[i].getAttribute("pointlist");			
	var shapeCoords = parseCoords(pointlist);

	// Construct the shapeObjectList.
//	alert(shapeCoords);
	if(shapeType == "polygon"){
//		var polygon = new BMap.Polygon([
//	        new BMap.Point(shapeCoords);
//	      ], {strokeColor:"blue", strokeWeight:6, strokeOpacity:0.5});
//	      map.addOverlay(polygon);
//		
		
		markersArray[shapeIndex] = new google.maps.Polygon({
			paths: shapeCoords,
			strokeColor: lineColor(colorNum),
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: coverColor(colorNum),
			fillOpacity: 0.35
		});
	}else if(shapeType == "polyline"){
		markersArray[shapeIndex] = new google.maps.Polyline({
			path: shapeCoords,
			strokeColor: lineColor(colorNum),
			strokeOpacity: 0.8,
			strokeWeight: 2
		});
	}else if(shapeType == "point"){
		markersArray[shapeIndex] = new google.maps.Marker({
			position: shapeCoords[0],
			icon: iconImage(colorNum)
		});		
	}

	markersArray[shapeIndex].setMap(mapActive);

	for(var j= 0;j<shapeCoords.length;j++)
		boundsActive.extend(shapeCoords[j]);
	mapActive.fitBounds(boundsActive);
	
	//alert(fieldNameList);
	var html = "";
	
	if(fieldNameList==""){
		html = "Object: " + i;		
	}
	else{
		var fieldNameArray = fieldNameList.split(','); 

		for(var j = 0;j<fieldNameArray.length;j++){
			var fieldValue = shapeXmlNode[i].getAttribute(fieldNameArray[j]);

			htmlTemp =   "<b>" + fieldNameArray[j] + " : " + fieldValue + "</b> <br/>";
			html += htmlTemp;
		}
	}
	
   // Add a listener for the click event
	google.maps.event.addListener(markersArray[shapeIndex], 'click', function(event) {
		infoWindow.setContent(html);
		infoWindow.setPosition(event.latLng);
		infoWindow.open(mapActive);
	});
}

function iconImage(colorNum){
	var img="";
	var is_voc = './../';
	var no_voc = '../../';
	vocIs = mapServer.match('voc');
	if(vocIs == 'voc'){
		spl = is_voc;
	}else if(vocIs == null){
		spl = no_voc;
	}
//	img = mapServer+spl+"images/"+colorNum+".png";
	img = "images/"+colorNum+".png";
	return img;
}

function lineColor(colorNum){
//	var num = colorNum % 64;
//	var onePart = 262000;
//	var lColor = (num * onePart).toString(16);		
//	var num = parseInt(colorNum,16);
//	var numPlus = num + 262000;
//	if(numPlus > 16777000) num = num - 262000;
//	else num = numPlus;
//	lColor = num.toString(16);
	lColor = "#"+colorNum
		return lColor;
}

function coverColor(colorNum){
//	var num = colorNum % 64;
//	var onePart = 250000;
//	var cColor = (num * onePart).toString(16);
	cColor = "#" + colorNum;
		return cColor;
}

function clearOverlay(markersArray){
//	infoWindow.close();
	for(var i=0;i<markersArray.length;i++)
		markersArray[i].setMap(null);
}

function addOverlay(markersArray,mapObj){
//	infoWindow.close();
	for(var i=0;i<markersArray.length;i++)
		markersArray[i].setMap(mapObj);
}

/*
 *�Զ�����ʾ��ķ��� 
 *С�ܸ���
 */
function createPointShape(fileName,mapActive,markersArray,colorNum){
	setActiveMap(mapActive);
	$.ajax({
		url:mapServer+'getPointShape.php',
		data:{"fileName":fileName},
		type:"get",
		dataType:"json",
		async:false,
		success:function (msg){
			for(i in msg){
				dataName = msg[i][1];
				lat = msg[i][3];
				lng = msg[i][2];
				createOnePointShape(dataName,mapActive,markersArray,colorNum,lat,lng);
			}
		}
	});
}

function createOnePointShape(dataName,mapActive,markersArray,colorNum,lat,lng){
	var shapeIndex = markersArray.length;
	
		markersArray[shapeIndex] = new google.maps.Marker({
	    position: new google.maps.LatLng(lat,lng),
	    icon: iconImage(colorNum),
	});
	markersArray[shapeIndex].setMap(mapActive);
	var html = dataName;
	// Add a listener for the click event
	google.maps.event.addListener(markersArray[shapeIndex], 'click', function(event) {
		infoWindow.setContent(html);
		infoWindow.setPosition(event.latLng);
		infoWindow.open(mapActive);
		showwave('map',1,8,colorNum);
	});
	
}

//����3D��ͼ�����ͼ��
//С�ܸ���
//2014-3-6
function create3DShape(fileName,fieldNameList,colorNum,size,instance){
	var urlShape = mapServer+"getShape_genxml.php"+"?f="+fileName+"&a="+fieldNameList;
	
	downloadUrl(urlShape,function(data){
		
		var xml = parseXml(data);	

		var shapeXmlNodes = xml.documentElement.getElementsByTagName("coords");	
		
		for (var i = 0; i < shapeXmlNodes.length; i++) {	
			create3DColorShape(i,shapeXmlNodes,fieldNameList,colorNum,size);
		}
		
	});
}

function create3DColorShape(i,shapeXmlNode,fieldNameList,colorNum,size){
	var pointlist = shapeXmlNode[i].getAttribute("pointlist");			
	var shapeCoords = parseCoords(pointlist);
	ge.getWindow().setVisibility(true);
    
 	  // �����رꡣ
    var polygonPlacemark = ge.createPlacemark('');

    // ��������Ρ�
    var polygon = ge.createPolygon('');
    polygon.setAltitudeMode(ge.ALTITUDE_RELATIVE_TO_GROUND);
    polygonPlacemark.setGeometry(polygon);

    // Ϊ�ⲿ��״�����Ӧ�ĵ㡣
    var outer = ge.createLinearRing('');
    outer.setAltitudeMode(ge.ALTITUDE_RELATIVE_TO_GROUND);
    for (var i=0;i<shapeCoords.length;i++){
		var shapeCoords1=shapeCoords[i].toString().slice(1);
		var shapeCoords2=shapeCoords1.substring(0, shapeCoords1.length - 1);
		var lat = shapeCoords2.substr(0, shapeCoords2.indexOf(','));
		var lng = shapeCoords2.split(',')[1];
	    outer.getCoordinates().pushLatLngAlt(parseFloat(lat),parseFloat(lng), size);
	}
    polygon.setOuterBoundary(outer);

    //������ʽ���������ߵĿ�Ⱥ���ɫ
    polygonPlacemark.setStyleSelector(ge.createStyle(''));
    var PolyStyle = polygonPlacemark.getStyleSelector().getPolyStyle();
    PolyStyle.getColor().set(colorNum);
    var lineStyle = polygonPlacemark.getStyleSelector().getLineStyle();
    lineStyle.setWidth(5);
    lineStyle.getColor().set(colorNum);

    // ��Google������ӵرꡣ
    ge.getFeatures().appendChild(polygonPlacemark);
}



/**
 *voc map 
 */
function createAllPointShape(shapeType,mapActive,markersArray,colorNum,pathName){
	setActiveMap(mapActive);
	$.ajax({
//		url:mapServer+'getAllPointShape.php',
		url:pathName,
		type:"get",
		dataType:"json",
		async:false,
		success:function (msg){
			var lineArr = [];
			for(i in msg){	
				dataName = msg[i]['insert_time'];
				lat = msg[i]['latitude'];
				lng = msg[i]['longitude'];
				dataType = msg[i]['type'];
				lineArr.push(new google.maps.LatLng(lat,lng));
				createOnePointShape(shapeType,dataName,mapActive,markersArray,colorNum,lat,lng,dataType,lineArr);
			}
		}
	});
}

function createAllLineShape(shapeType,mapActive,markersArray,colorNum,pathName){
	setActiveMap(mapActive);
	$.ajax({
//		url:mapServer+'getAllPointShape.php',
		url:pathName,
		type:"get",
		dataType:"json",
		async:false,
		success:function (msg){
			var lineArr = [];
			for(i in msg){	
				dataName = msg[i]['insert_time'];
				lat = msg[i]['latitude'];
				lng = msg[i]['longitude'];
				dataType = msg[i]['type'];
				lineArr.push(new google.maps.LatLng(lat,lng));
				createOnePointShape(shapeType,dataName,mapActive,markersArray,colorNum,lat,lng,dataType,lineArr);
			}
		}
	});
}

function createOnePointShape(shapeType,dataName,mapActive,markersArray,colorNum,lat,lng,dataType,lineArr){
	var shapeIndex = markersArray.length;
	
	if(shapeType == "polyline"){
		markersArray[shapeIndex] = new google.maps.Polyline({
			path:lineArr,
			strokeColor: lineColor(colorNum),
			strokeOpacity: 0.8,
			strokeWeight: 2
		});
	}else if(shapeType == "point"){
		if(dataType == "2"){
			colorNum = "poi_13";
		}else if(dataType == "3"){
			colorNum = "poi_14";
		}
		markersArray[shapeIndex] = new google.maps.Marker({
	    position: new google.maps.LatLng(lat,lng),
	    icon: iconImage(colorNum),
		});
		
		if(dataType == "2"){
			typeName = "签到时间 :";
		}else if(dataType == "3"){
			typeName = "签退时间 :";
		}
		var html = '<div class="cue-title" style="position:relative;">'+typeName+dataName+'</div>';
		// Add a listener for the click event
		google.maps.event.addListener(markersArray[shapeIndex], 'click', function(event) {
			infoWindow.setContent(html);
			infoWindow.setPosition(event.latLng);
			infoWindow.open(mapActive);
//			showwave('map',1,8,colorNum);
		});
	}
	markersArray[shapeIndex].setMap(mapActive);
}
