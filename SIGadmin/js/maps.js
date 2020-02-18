var peta;
var peta2;
var lokasi=[];
var lokasi2=[];

function maps()
{
	var pilihan=
	{
		zoom:14,
		center:new google.maps.LatLng(1.0485362670386824,120.80969621388726)
	};

	peta=new google.maps.Map(document.getElementById("kotaklokevakuasi"), pilihan);	
	peta2=new google.maps.Map(document.getElementById("kotaklokevakuasi2"), pilihan);	


	google.maps.event.addListener(peta, 'click', function( event )
	{
		lokasi = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()); 
		document.getElementById('lat1').value=event.latLng.lat();
		document.getElementById('lng1').value=event.latLng.lng();
		buattitik();

	});

	google.maps.event.addListener(peta2, 'click', function( event )
	{
		lokasi2 = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()); 
		document.getElementById('lat').value=event.latLng.lat();
		document.getElementById('lng').value=event.latLng.lng();
		buattitik2();

	});

}

var markerr=[];

function buattitik()
{  
	if(markerr.length>0)
	{
		markerr[0].setMap(null);
		markerr=[];
	};

	marker = new google.maps.Marker({
					    position: lokasi,
					    map: peta,
					    title: "Lokasi Evakuasi",
					    icon:"images/markeraktif.png"
					});

	markerr.push(marker);

}

var markerr2=[];

function buattitik2()
{  
	if(markerr2.length>0)
	{
		markerr2[0].setMap(null);
		markerr2=[];
	};

	marker = new google.maps.Marker({
					    position: lokasi2,
					    map: peta2,
					    title: "Lokasi Evakuasi",
					    icon:"images/markeraktif.png"
					});

	markerr2.push(marker);

}
