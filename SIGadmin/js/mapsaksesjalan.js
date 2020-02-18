var peta;
var peta2;
var lokasi=[];
var lokasi2=[];

function mapsaksesjalan()
{
	var pilihan=
	{
		zoom:14,
		center:new google.maps.LatLng(1.0485362670386824,120.80969621388726)
	};

	peta=new google.maps.Map(document.getElementById("kotakpemblokiran"), pilihan);
	peta2=new google.maps.Map(document.getElementById("kotaklihatjalan"), pilihan);	
	peta3=new google.maps.Map(document.getElementById("kotaklihatsemuajalan"), pilihan);
	
	polygon = new google.maps.Polygon({
          strokeColor: '#FF0000',
        });
	

	google.maps.event.addListener(peta, 'click', function(event) 
	{
		if( titik == true )
		{
			// tempattitik = garispoli.getPath();
			tempattitik = polygon.getPath();
			tempattitik.push(event.latLng);	
			
		}
	});

}

param=true;

function tampilpoly1()
{
	
	jQuery.ajax({
	    type: "POST",
	    url: "phpjalan/maps1.php",
	    dataType: "json",
	    success: function(result)
	    {
	    	var koor=result;

		  	// hapus line rute
		    for (var i = 0; i < gariss.length; i++) 
		    {
		        gariss[i].setMap(null);
		    };
		    gariss=[];

		   	//hapus simpul
		   	simpul=[];

		   	gambar(koor);

		   	for (var i = 0; i < gariss.length; i++) 
			{
				google.maps.event.addListener(gariss[i],"mouseover",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.5'});
				});

				google.maps.event.addListener(gariss[i],"mouseout",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.1'});
				});

				google.maps.event.addListener(gariss[i],"click",(function(i)
				{ 
					return function() 
					{
						var r = confirm("Apakah anda ingin memblokir akses jalan ini?");
					    if (r == true) 
					    {
							s=simpul[i].split('-');
							s1=s[0];
							s2=s[1];
							window.location="phpjalan/crudjalan.php?simpan=1&simpul1="+s1+"&simpul2="+s2;
						}

					};
				})(i)); 
				
				
			};
	    },
	    error:function()
	    {
	        console.log("Error")
	    }
	});
}

function tampilpoly2()
{
	jQuery.ajax({
		type: "POST",
		url: "phpjalan/maps2.php",
		dataType: "json",
		success: function(result)
		{
		  	var koor=result;

		  	// hapus line rute
		    for (var i = 0; i < gariss.length; i++) 
		    {
		        gariss[i].setMap(null);
		    };
		    gariss=[];

		   	//hapus simpul
		   	simpul=[];

		   	gambar(koor);

		   	for (var i = 0; i < gariss.length; i++) 
			{
				google.maps.event.addListener(gariss[i],"mouseover",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.5'});
				});

				google.maps.event.addListener(gariss[i],"mouseout",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.1'});
				});

				google.maps.event.addListener(gariss[i],"click",(function(i)
				{ 
					return function() 
					{
						var r = confirm("Apakah anda ingin memblokir akses jalan ini?");
					    if (r == true) 
					    {
							s=simpul[i].split('-');
							s1=s[0];
							s2=s[1];
							window.location="phpjalan/crudjalan.php?simpan=1&simpul1="+s1+"&simpul2="+s2;
						}
					};
				})(i)); 
				
				
			};
		},
		error:function()
	    {
	        console.log("Error")
	    }
	});
}


function tampilpoly3()
{
	jQuery.ajax({
		type: "POST",
		url: "phpjalan/maps3.php",
		dataType: "json",
		success: function(result)
		{
		  	var koor=result;

		  	// hapus line rute
		    for (var i = 0; i < gariss.length; i++) 
		    {
		        gariss[i].setMap(null);
		    };
		    gariss=[];

		   	//hapus simpul
		   	simpul=[];

		   	gambar(koor);

		   	for (var i = 0; i < gariss.length; i++) 
			{
				google.maps.event.addListener(gariss[i],"mouseover",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.5'});
				});

				google.maps.event.addListener(gariss[i],"mouseout",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.1'});
				});

				google.maps.event.addListener(gariss[i],"click",(function(i)
				{ 
					return function() 
					{
						var r = confirm("Apakah anda ingin memblokir akses jalan ini?");
					    if (r == true) 
					    {
							s=simpul[i].split('-');
							s1=s[0];
							s2=s[1];
							window.location="phpjalan/crudjalan.php?simpan=1&simpul1="+s1+"&simpul2="+s2;
						}
					};
				})(i)); 
				
				
			};
		},
		error:function()
		{
		    console.log("Error")
		}
	});
}

function tampilpoly4()
{
	param=true;

	jQuery.ajax({
		type: "POST",
		url: "phpjalan/maps4.php",
		dataType: "json",
		success: function(result)
		{
		  	var koor=result;

		  	// hapus line rute
		    for (var i = 0; i < gariss.length; i++) 
		    {
		        gariss[i].setMap(null);
		    };
		    gariss=[];

		   	//hapus simpul
		   	simpul=[];

		   	gambar(koor);

		   	for (var i = 0; i < gariss.length; i++) 
			{
				google.maps.event.addListener(gariss[i],"mouseover",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.5'});
				});

				google.maps.event.addListener(gariss[i],"mouseout",function() 
				{
				  	this.setOptions({strokeColor: '#4682B4'});
				  	this.setOptions({strokeOpacity: '0.1'});
				});

				google.maps.event.addListener(gariss[i],"click",(function(i)
				{ 
					return function() 
					{
						var r = confirm("Apakah anda ingin memblokir akses jalan ini?");
					    if (r == true) 
					    {
							s=simpul[i].split('-');
							s1=s[0];
							s2=s[1];
							window.location="phpjalan/crudjalan.php?simpan=1&simpul1="+s1+"&simpul2="+s2;
						}
					};
				})(i)); 
				
				
			};

		},
		error:function()
		{
		    console.log("Error")
		}
	});

}

var gariss=[];
var simpul=[];
function gambar(koor)
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
				simpul.push(key1+'-'+key2);
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
		garis.setMap(peta);
		gariss.push(garis);
		
	});


	// $.each(koor, function(key1, value1) 
	// {
	// 	$.each(value1, function(key2='0', value2) 
	// 	{
	// 		var a=key1;
	// 		var lokasi = new google.maps.LatLng(koor[key1][key2]['lat'][0],koor[key1][key2]['lng'][0])
	// 		var marker = new google.maps.Marker({
	// 		    position: lokasi,
	// 		    map: peta,
	// 		    title: a
	// 		});
	// 		var konten_marker = "<div>" +a+ "</div>";
	// 		var infowindow_marker = new google.maps.InfoWindow();	
	// 		//infowindow_marker.open(peta,marker);		
	// 		google.maps.event.addListener(marker,'click', (function(marker,konten_marker,infowindow_marker)
	// 		{ 
	// 			return function() {
	// 				infowindow_marker.setContent(konten_marker);
	// 				infowindow_marker.open(peta,marker);
	// 			};
	// 		})(marker,konten_marker,infowindow_marker)); 
	// 	});
	// });
				 
	// };
}



var titik=false;
var tempattitik=new Array;; 
var polygonakhir=new Array; 
var garispoli;
var str=''; 
var point=[];

function tambah_poligon()
{
	// hapus line rute
	for (var i = 0; i < gariss.length; i++) 
	{
		gariss[i].setMap(null);
	};
	gariss=[];

	//hapus simpul
	simpul=[];
	
	if(document.getElementById('d5').innerHTML=='Gambar')
	{
		var pilihan ={
          strokeColor: '#4682B4',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#4682B4',
          fillOpacity: 0.1,
          editable: true,
        };
    
	    polygon=new google.maps.Polygon(pilihan);
	    polygon.setMap(peta);
		titik = true;
		document.getElementById('d5').innerHTML='Selesai';
	}
	else if(document.getElementById('d5').innerHTML=='Selesai') 
	{
		str="";

		Object.size = function(obj) 
		{
		    var size = 0, key;
		    for (key in obj) {
		        if (obj.hasOwnProperty(key)) size++;
		    }
		    return size;
		};
        
        // console.log(tempattitik);
		i=0;
		for (var key in tempattitik.g) 
		{
		  //  console.log(tempattitik.g);
			lat1=tempattitik.g[key].lat();
			lng2=tempattitik.g[key].lng();

			latlng ='['+lat1+','+lng2+']';
			if (i==Object.size(tempattitik.g)-1)
			{
				str+=latlng;
			}
			else
			{
				str+=latlng+',';
				i++;
			}
			
		}


		tempattitiklat=[];
		tempattitiklng=[];
		
		titik = false;
		// json=JSON.stringify(polygonakhir);
		polygon.setOptions({editable: false});
		document.getElementById('txt').innerHTML =str;
		document.getElementById('d5').innerHTML='Simpan';
	}
	else if(document.getElementById('d5').innerHTML=='Simpan')
	{
		var r = confirm("Apakah anda ingin memblokir akses jalan pada daerah gambar ini?");
		if (r == true) 
		{
			strsimpan=document.getElementById('txt').innerHTML;
			window.location="phpjalan/crudjalan.php?simpan=2&string="+strsimpan;
		}
	}
}

var polygon;


function batal()
{
    window.location='pemblokiranjalan.php';
}

function hapusgambar()
{
	polygon.setMap(null);

	document.getElementById('txt').innerHTML ='';
	document.getElementById('d5').innerHTML='Gambar';
	titik=false;
	tempattitik=[];
	polygonakhir=[];
	point=[];
	polygon = new google.maps.Polygon({
          strokeColor: '#FF0000',
        });
	str=''; 
}

