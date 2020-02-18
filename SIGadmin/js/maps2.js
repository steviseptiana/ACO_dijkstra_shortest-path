var peta3;
//variable yang digunakan untuk menyimpan data infowindow
var infowindowarr=[];
//variable yang digunakan untuk menyimpan data marke
var markerarr=[];
//variable yang digunakan untuk menyimpan data title marker window
var titleinfowindow=[];
//var arrayanimasi;

function maps2()
{
	var pilihan=
	{
		zoom:14,
		center:new google.maps.LatLng(1.0485362670386824,120.80969621388726)
	};

	peta3=new google.maps.Map(document.getElementById("kotaklokasievakuasi"), pilihan);	


    var icon = 
    {
        url: "images/markeraktif.png",
         // url
        // scaledSize: new google.maps.Size(30, 40), // scaled size
        // origin: new google.maps.Point(0,0), // origin
        // anchor: new google.maps.Point(0, 0) // anchor
    };

	jQuery.ajax(
    {
        type: "POST",
        url: "php/markerlokasiaktif.php",
        dataType: "json",
        success: function(result)
        {
        	var datalokevk=result;
        	// console.log(datalokevk);

            $.each(datalokevk,function(key1) 
            {
                var lokasi = new google.maps.LatLng(datalokevk[key1]['lat'],datalokevk[key1]['lng']);
                var marker = new google.maps.Marker({
                    position: lokasi,
                    map: peta3,
                    title: " "+datalokevk[key1]['id'],
                    icon: icon
                });

                var konten_marker = "<div style='font-size: 12px; font-family: Roboto, Arial, sans-serif;'>"+datalokevk[key1]['id']+"</div>"+
                "<div style="+"text-align:justify; font-size: 12px; font-family: Roboto, Arial, sans-serif;> ("+ datalokevk[key1]['lat']+","+ datalokevk[key1]['lng']+")"+
                "<div style='text-align:justify; font-family: Roboto, Arial, sans-serif; font-weight:bold; font-size: 14px;'>"+datalokevk[key1]['status']+"</div>";
                
                infowindow_marker = new google.maps.InfoWindow();

                infowindowarr.push(infowindow_marker);
                markerarr.push(marker);
                z=" "+konten_marker+" ";
                titleinfowindow.push(z);

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
    
    jQuery.ajax(
    {
        type: "POST",
        url: "php/markerlokasitidakaktif.php",
        dataType: "json",
        success: function(result)
        {
            var datalokevk=result;
            // console.log(datalokevk);

            $.each(datalokevk,function(key1) 
            {
                var lokasi = new google.maps.LatLng(datalokevk[key1]['lat'],datalokevk[key1]['lng']);
                var marker = new google.maps.Marker({
                    position: lokasi,
                    map: peta3,
                    title: " "+datalokevk[key1]['id'],
                    icon: 'images/markertidakaktif.png'
                });

                var konten_marker = "<div style='font-size: 12px; font-family: Roboto, Arial, sans-serif;'>"+datalokevk[key1]['id']+"</div>"+
                "<div style="+"text-align:justify; font-size: 12px; font-family: Roboto, Arial, sans-serif;> ("+ datalokevk[key1]['lat']+","+ datalokevk[key1]['lng']+")"+
                "<div style='text-align:justify; font-family: Roboto, Arial, sans-serif; font-weight:bold; font-size: 14px;'>"+datalokevk[key1]['status']+"</div>";
                
                infowindow_marker = new google.maps.InfoWindow();

                infowindowarr.push(infowindow_marker);
                markerarr.push(marker);
                z=" "+konten_marker+" ";
                titleinfowindow.push(z);

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