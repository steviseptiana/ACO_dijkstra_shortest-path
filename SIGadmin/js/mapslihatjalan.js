var koordinatlat;
var koordinatlng;
var ta;
var tt;
var garissjalan=[];
var markerrjalan=[];
var info=[];
var peta3;
// var simpulawal;
// var simpultujuan;

function mapslihatjalan()
{
	lat=[];
	lng=[];
	// hapus line rute
	for (var i = 0; i < garissjalan.length; i++) 
	{
		garissjalan[i].setMap(null);
	};
	garissjalan=[];

	for (var i = 0; i < markerrjalan.length; i++) 
	{
		markerrjalan[i].setMap(null);
		info[i].setMap(null);
	};

	markerrjalan=[];
	info=[];


	lat=koordinatlat.split('#');
	lat.shift();
	lng=koordinatlng.split('#');
	lng.shift();

	//marker
	mark(lat[0],lng[0],ta);
	mark(lat[lng.length-1],lng[lat.length-1],tt);

	peta2.setCenter(new google.maps.LatLng(lat[0],lng[0]));
	peta2.setZoom(15);

	var poly=new Array();
		for (var i = 0; i < lat.length; i++) 
		{
			var pos = new google.maps.LatLng(lat[i],lng[i]);
			poly.push(pos);

			var polyOptions = {
						path:poly,
						strokeColor:'#4682B4',
						strokeOpacity:0.5,
						strokeWeight:10
	   		};
	   	};

	var polyline = new google.maps.Polyline(polyOptions);
	polyline.setMap(peta2);

	garissjalan.push(polyline);
	
}

function mark(lat,lng,a)
{
	var lokasi = new google.maps.LatLng(lat,lng);
			var marker = new google.maps.Marker({
			    position: lokasi,
			    map: peta2,
			    icon:'images/marker.png',
			    title: a
			});
			var konten_marker = "<div>" +a+ "</div>";
			var infowindow_marker = new google.maps.InfoWindow();	
			
			infowindow_marker.setContent(konten_marker);
			infowindow_marker.open(peta2,marker);

			google.maps.event.addListener(marker,'click', (function(marker,konten_marker,infowindow_marker)
			{ 
				return function() {
					infowindow_marker.setContent(konten_marker);
					infowindow_marker.open(peta2,marker);
				};
			})(marker,konten_marker,infowindow_marker)); 


			markerrjalan.push(marker);
			info.push(infowindow_marker);
}

function mapslihatsemuajalan()
{
	// hapus line rute
	for (var i = 0; i < gariss.length; i++) 
	{
		gariss[i].setMap(null);
	};
	gariss=[];

	//hapus simpul
	simpul=[];

	jQuery.ajax({
	    type: "POST",
	    url: "phpjalan/blokirjalan.php",
	    dataType: "json",
	    success: function(result)
	    {
	    	var koor=result;

		  	// hapus line rute
		    for (var i = 0; i < garisss.length; i++) 
		    {
		        garisss[i].setMap(null);
		    };
		    garisss=[];

		   	//hapus simpul
		   	simpulll=[];

		   	gambar1(koor);

		   	for (var i = 0; i < garisss.length; i++) 
			{
				google.maps.event.addListener(garisss[i],"mouseover",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.5'});
				});

				google.maps.event.addListener(garisss[i],"mouseout",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.1'});
				});

				google.maps.event.addListener(garisss[i],"click",(function(i)
				{ 
					return function() 
					{
						alert(simpulll[i]);
					};
				})(i)); 
				
			};
	    },
	    error:function()
	    {
	        console.log("Error")
	    }
	});

	jQuery.ajax({
    type: "POST",
    url: "phpjalan/marker.php",
    dataType: "json",
    success: function(result)
    {
    	var koor=result;

		$.each(koor, function(key1, value1) 
			{
				
					var a=key1;
					var lokasi = new google.maps.LatLng(koor[key1]['lat'],koor[key1]['lng'])
					var marker = new google.maps.Marker({
					    position: lokasi,
					    map: peta3,
					    icon:'images/marker.png',
					    title: a
					});

					var konten_marker = "<div>" +a+ "</div>";
					var infowindow_marker = new google.maps.InfoWindow();	
					//infowindow_marker.open(peta,marker);		
					google.maps.event.addListener(marker,'click', (function(marker,konten_marker,infowindow_marker)
					{ 
						return function() {
							infowindow_marker.setContent(konten_marker);
							infowindow_marker.open(peta3,marker);
						};
					})(marker,konten_marker,infowindow_marker)); 

				
			});
    },
    error:function()
    {
        console.log("Error")
    }
    });
}

var garisss=[];
var simpulll=[];
function gambar1(koor)
{
	i=0;
	var latitude= new Array;
	var longitude= new Array;
	var markerlat= new Array;
	var markerlatlng= new Array;
	
	$.each(koor, function(key1, value1) 
	{
		$.each(value1, function(key2, value2) 
		{
			$.each(value2, function(key3, value3) 
			{
				latitude[i]=koor[key1][key2]['lat'];
				longitude[i]=koor[key1][key2]['lng'];
				simpulll.push(key1+'-'+key2);
				i++;
			});
		});
	});	

	$.each(latitude, function(key1, value1) 
	{
		var poly = new Array(); 
		$.each(value1, function(key2, value2) 
		{  
			var pos = new google.maps.LatLng(latitude[key1][key2],longitude[key1][key2]);
	    	poly.push(pos);
		});

		var garis=new google.maps.Polyline({
				path:poly,
				strokeColor:'#4682B4',
				strokeOpacity:0.1,
				strokeWeight:10
			});
		garis.setMap(peta3);
		garisss.push(garis);
		
	});

}


function callbuttonjalan()
{
	$('#Modallihatsemuajalan').modal('show'); 
	mapslihatsemuajalan();
}
