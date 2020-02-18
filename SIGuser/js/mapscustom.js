var petacustom;

//variable yang digunakan untuk menyimpan data infowindow
var infowindowarr=[];
//variable yang digunakan untuk menyimpan data marke
var markerarr=[];
//variable yang digunakan untuk menyimpan data title marker window
var titleinfowindow=[];
//var arrayanimasi;

var param=false; 

var rute;
var poly;
var obj=[];
var lat;
var lng;
var bobot;
var idevk;

var konfirmasi=false;

var paramklikpeta=false;

paramerror=false;

function maps()
{
    var pilihan=
    {
        zoom:15,
        center:new google.maps.LatLng(1.042126, 120.817032)
    };

    petacustom=new google.maps.Map(document.getElementById("kotakrute"), pilihan); 

     mapslihatsemuajalan();


    if(paramklikpeta==false)
    {
        google.maps.event.addListener(petacustom, 'click', function( event )
        {
            klikpeta(event.latLng.lat(),event.latLng.lng());

            if(konfirmasi==true)
            {
                alert("Maaf, Lokasi yang anda pilih berada diluar daerah Kecamatan Bolan, Kabupaten Toli-Toli.")
            }
            else
            {
                lokasi = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()); 
                buattitik();

                var r = confirm("Temukan jalur terpendek menuju lokasi evakuasi!");
                if (r == true) 
                {
                  window.location.href="php/algoritma/panggiljs.php?latawal="+event.latLng.lat()+"&lngawal="+event.latLng.lng();
                }
            }
            

        });   
    }

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
                    map: petacustom,
                    title: " "+datalokevk[key1]['id'],
                    icon: 'images/markeraktif.png'
                });

                var konten_marker = "<div style='font-weight:bold; font-size: 1em; font-family: Roboto, Arial, sans-serif;'>"+"Lokasi Evakuasi "+datalokevk[key1]['id']+"</div>"+
                "<div style="+"text-align:justify; font-size: 0.3em; font-family: Roboto, Arial, sans-serif;> ("+ datalokevk[key1]['lat']+","+ datalokevk[key1]['lng']+")</div>";

                infowindow_marker = new google.maps.InfoWindow();

                infowindowarr.push(infowindow_marker);
                markerarr.push(marker);
                z=" "+konten_marker+" ";
                titleinfowindow.push(z);

                google.maps.event.addListener(marker,'click', (function(marker,konten_marker,infowindow_marker)
                { 
                    return function() {
                        infowindow_marker.setContent(konten_marker);
                        infowindow_marker.open(petacustom,marker);
                    };
                })(marker,konten_marker,infowindow_marker)); 
            
            });
 
        },
        error:function()
        {
            console.log("Error")
        }
    });

    if(paramerror==true)
    {
        lokasi = new google.maps.LatLng(lat,lng); 
        buattitik();
    }

    
    if(param==true)
    {

        lokasi = new google.maps.LatLng(lat,lng); 
        buattitik();
        
        poly=[];                   
        for (var i = 0; i < obj.length; i++) 
        {
            x=JSON.parse(obj[i]); 
            for (var j = 0; j < x.length; j++) 
            {
                poly.push(new google.maps.LatLng(x[j][0],x[j][1])); 
            };
        };

        polyline(poly); 

        var middle = obj[Math.floor((obj.length - 1) / 2)];
        x=JSON.parse(middle); 
        var middle2 = x[Math.floor((x.length - 1) / 2)];

        var boxText = document.createElement("div");
            boxText.style.cssText = "font-size:1em; border: 1px solid #bce8f1; margin-top: 8px; background: white; padding: 1px;font-Weight:bold";
            boxText.innerHTML = (bobot/1000).toFixed(3)+" KM";
        var gam=gambaralabel(boxText, middle2[0],middle2[1],"60px");

        //label tujuan
        x=obj.length-1;
        s=JSON.parse(obj[x]);
        lattujuan= s[s.length-1][0];
        lngtujuan= s[s.length-1][1];

        var myOptions = 
        {
            content: "Lokasi evakuasi terdekat",
            maxWidth: "200px",
            boxStyle: 
            {
                border: "none",
                textAlign: "center",
                fontSize: "12pt",
                background: "white",
                opacity: "0.7",
                padding: "1px",
                color:"red",
            },
            disableAutoPan: true,
            pixelOffset: new google.maps.Size(0, -10),
            position: new google.maps.LatLng(lattujuan,lngtujuan),
            closeBoxURL: "",
            isHidden: false,
            pane: "mapPane",
            enableEventPropagation: true
        };

        var ibLabel = new InfoBox(myOptions);
        ibLabel.open(petacustom);
    }

    
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
                        map: petacustom,
                        title: "Lokasi User",
                        icon:"images/locate.png"
                    });

    var konten_marker = "<div style='text-align:justify; font-weight:bold; font-size: 1em; font-family: Roboto, Arial, sans-serif;'>"+"Lokasi User"+"</div>"+ 
    "<div style="+"text-align:justify; font-size: 0.3em; font-family: Roboto, Arial, sans-serif;> ("+lokasi.lat()+","+lokasi.lng()+") </div>";
    var infowindow_marker = new google.maps.InfoWindow();

    infowindow_marker.setContent(konten_marker);
    // infowindow_marker.open(petacustom,marker);

    google.maps.event.addListener(marker,'click', (function(marker,konten_marker,infowindow_marker)
    { 
        return function() {
            infowindow_marker.setContent(konten_marker);
            infowindow_marker.open(petacustom,marker);
        };
    })(marker,konten_marker,infowindow_marker));

    markerr.push(marker);

}

var markernote=[];
function gambaralabel(boxText,lat,lng,uk)
{
    latlng=new google.maps.LatLng(lat,lng);
    var note = new google.maps.Marker({
        position:latlng,
        map: petacustom,
        icon:".png"
      });

    var myOptions = {
         content: boxText
        ,disableAutoPan: false
        ,maxWidth: 0
        ,zIndex: null
        ,boxStyle: { 
           // background: "#5f9bc3"
           opacity: 0.7
          ,width: uk
         }
        ,isHidden: false
        ,pane: "floatPane"
        ,enableEventPropagation: false
    };

    var ib = new InfoBox(myOptions);
    
   
    ib.open(petacustom, note);

    markernote[0]=ib;
    markernote[1]=note;

}


function klikpeta(lat,lng)
{

    koordinatbaolan=[{lat:0.9476697852255543,lng:120.81844372113517},{lat:0.9505018093633331,lng:120.81192058881095},{lat:0.9553934819453985,lng:120.80428165753654},{lat:0.9587404118066901,lng:120.80127758343986},{lat:0.9612292383557329,lng:120.78762813310993},{lat:0.9678372649198876,lng:120.77981754045857},{lat:0.9701543620994092,lng:120.769088704399},{lat:0.9681221346936866,lng:120.76249591982287},{lat:0.9694321963967036,lng:120.75792410466715},{lat:0.9699692475875645,lng:120.75420665772049},{lat:0.9733161631167678,lng:120.74562358887283},{lat:0.9764914388819496,lng:120.7427911761531},{lat:0.9824987091437307,lng:120.74493694336502},{lat:0.9865969143859884,lng:120.74776935608475},{lat:0.995582398979199,lng:120.74476528198807},{lat:0.9972987531579228,lng:120.74596691162674},{lat:0.9981445576815147,lng:120.74694777749028},{lat:1.0006332690098498,lng:120.74789191506352},{lat:1.0014914448924204,lng:120.74909354470219},{lat:1.0014056273142697,lng:120.75038100502934},{lat:1.001062356979213,lng:120.75218344948735},{lat:1.0021779854366983,lng:120.75252677224125},{lat:1.003808518652449,lng:120.75312758706059},{lat:1.0039801536805102,lng:120.75415755532231},{lat:1.0056106859975633,lng:120.75441504738774},{lat:1.0062114082249116,lng:120.75587416909184},{lat:1.0054390510551483,lng:120.75707579873051},{lat:1.0047525111953002,lng:120.75810576699223},{lat:1.0054390510551483,lng:120.75913573525395},{lat:1.0072412175001273,lng:120.75904990456547},{lat:1.0087859308026534,lng:120.75836325905766},{lat:1.01050227805647,lng:120.75776244423832},{lat:1.010931364728294,lng:120.75904990456547},{lat:1.0117037205946406,lng:120.7604231955811},{lat:1.011961172509247,lng:120.76231147072758},{lat:1.0129909799632517,lng:120.76359893105473},{lat:1.0133342490418875,lng:120.76557303688969},{lat:1.0147073249924865,lng:120.76668883583989},{lat:1.0163378519268071,lng:120.76814795754399},{lat:1.0179683780379367,lng:120.76909209511723},{lat:1.017710926601482,lng:120.77012206337895},{lat:1.0165094862930713,lng:120.7702937247559},{lat:1.0169385721688533,lng:120.77115203164067},{lat:1.018225829453832,lng:120.77226783059086},{lat:1.0209719766096934,lng:120.77389861367192},{lat:1.0227449956207724,lng:120.77526039339898},{lat:1.0246329693871095,lng:120.77671951510308},{lat:1.025233688079513,lng:120.7792086050689},{lat:1.025920223589978,lng:120.78083938814996},{lat:1.027894012361613,lng:120.78272766329644},{lat:1.0290954484080679,lng:120.78401512362359},{lat:1.0303827008127782,lng:120.78513092257379},{lat:1.0319274030117969,lng:120.78659004427789},{lat:1.0319274030117969,lng:120.78770584322808},{lat:1.030640151231328,lng:120.78882164217828},{lat:1.030788367166971,lng:120.79124844780517},{lat:1.0306167335649055,lng:120.79270756950928},{lat:1.0307025503671023,lng:120.79468167534424},{lat:1.0306167335649055,lng:120.79656995049072},{lat:1.0290720307302972,lng:120.79820073357178},{lat:1.0289862138842087,lng:120.79965985527588},{lat:1.029243664415541,lng:120.80266392937256},{lat:1.0294152980915736,lng:120.80498135796142},{lat:1.0290720307302972,lng:120.80772793999267},{lat:1.0305309167604058,lng:120.80841458550049},{lat:1.0341352205563417,lng:120.80892956963135},{lat:1.0362806375402618,lng:120.80867207756592},{lat:1.0405714671457167,lng:120.80755627861572},{lat:1.0422877973550044,lng:120.80772793999267},{lat:1.0434034114895359,lng:120.80635464897705},{lat:1.0449481073302824,lng:120.80644047966553},{lat:1.045634638571311,lng:120.80807126274658},{lat:1.0472651496668253,lng:120.80824292412353},{lat:1.049324741416987,lng:120.80815709343506},{lat:1.0506978018305764,lng:120.80686963310791},{lat:1.0514701480480615,lng:120.80566800346924},{lat:1.0520708616406746,lng:120.80386555901123},{lat:1.0517275967447735,lng:120.80240643730713},{lat:1.0503545367837135,lng:120.80137646904541},{lat:1.049496374001657,lng:120.80000317802978},{lat:1.0499254554221433,lng:120.79785741081787},{lat:1.0513843318111127,lng:120.79588330498291},{lat:1.053787185553469,lng:120.79502499809814},{lat:1.0561615519501348,lng:120.79590519749922},{lat:1.0593367462678376,lng:120.79667767369551},{lat:1.0613105140692614,lng:120.79719265782637},{lat:1.0643998872288196,lng:120.79684933507247},{lat:1.0667169150679363,lng:120.79642018163008},{lat:1.0691197569100819,lng:120.79667767369551},{lat:1.070063729976641,lng:120.79796513402266},{lat:1.0711793341353246,lng:120.798565948842},{lat:1.0704069928379285,lng:120.80594738805098},{lat:1.0675750730843006,lng:120.81435879552168},{lat:1.070254365481186,lng:120.82284682744444},{lat:1.0703401811947808,lng:120.82928412908018},{lat:1.0704259969059586,lng:120.83546393865049},{lat:1.0646763389561027,lng:120.84215873235166},{lat:1.0520613802917405,lng:120.84868186467588},{lat:1.0373867724045935,lng:120.85348838323057},{lat:1.0243426193400302,lng:120.84730857366026},{lat:1.007720832719436,lng:120.84314299885887},{lat:0.9923594796809944,lng:120.83953810994285},{lat:0.9728804794459899,lng:120.83722238236749},{lat:0.9593211584852877,lng:120.83181504899346},{lat:0.9511683762964288,lng:120.82469110184991},{lat:0.9497094553419726,lng:120.81962709122979}];

    var baolan = new google.maps.Polygon({paths: koordinatbaolan});

    titik=new google.maps.LatLng(lat,lng)

    var resultPath = google.maps.geometry.poly.containsLocation(titik, baolan) ? konfirmasi=false: konfirmasi=true;

}

var index;


$(document).on("click", ".open-homeEvents", function () 
{   
    // hapus line rute
    for (var i = 0; i < gariss.length; i++) 
    {
        gariss[i].setMap(null);
    };
    gariss=[];

    // hapus note
    if( markernote.length>0)
    {
        markernote[0].open(null, markernote[1]);
        markernote=[];
    };

    
    index = $(this).data('id');
    rutecs=rute[index]['Koordinat'];
    hasilrutecs=[];

    $.each(rutecs, function(key1, value1) 
    {
        $.each(value1, function(key2, value2) 
        {
            hasilrutecs.push("["+value2+"]")
        });
    }); 

    
    
    for (var i = 0; i < hasilrutecs.length; i++) 
    {
        poly=[];    
        x=JSON.parse(hasilrutecs[i]); 
        for (var j = 0; j < x.length; j++) 
        {
            poly.push(new google.maps.LatLng(x[j][0],x[j][1]));
        };
        polyline(poly);   
    };

    
    var middle =hasilrutecs[Math.floor((hasilrutecs.length - 1) / 2)];
    x=JSON.parse(middle); 
    var middle2 = x[Math.floor((x.length - 1) / 2)];

    var boxText = document.createElement("div");
        boxText.style.cssText = "font-size:1em; border: 1px solid #bce8f1; margin-top: 8px; background: white; padding: 1px;font-Weight:bold";
        boxText.innerHTML = (rute[index]['Bobot']/1000).toFixed(3)+" KM";
    gambaralabel(boxText, middle2[0],middle2[1],"65px");

});

var gariss=[];
function polyline(poly)
{
    
    var garis=new google.maps.Polyline({
                        path:poly,
                        strokeColor:'#77aad2',
                        // strokeOpacity: 0.9,
                        strokeWeight: 8
                    });

    garis.setMap(petacustom);

    gariss.push(garis);
}

function mapslihatsemuajalan()
{
    jQuery.ajax({
    type: "POST",
    url: "phpjalan/mapsjalan.php",
    dataType: "json",
    success: function(result)
    {

        var koor=result;
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
                        i++;
                    });
                });
            }); 


            x=0;
            $.each(latitude, function(key1, value1) 
            {
                var poly = new Array(); 
                $.each(value1, function(key2, value2) 
                {  
                    var pos = new google.maps.LatLng(latitude[key1][key2],longitude[key1][key2]);
                    poly.push(pos);
                    
                });

                gambarj(poly);

            });


    },
    error:function()
    {
        console.log("Error")
    }
    });

}

function gambarj(poly)
{
    var garis=new google.maps.Polyline({
                        path:poly,
                        strokeColor:'#F08080',
                        // strokeOpacity:0.5,
                        strokeWeight:8
                    });

                garis.setMap(petacustom);
}

