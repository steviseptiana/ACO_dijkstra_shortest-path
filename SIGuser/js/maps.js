var peta;

var infoWindow;

function maps()
{
  	var pilihan=
  	{
  		zoom:15,
  		center:new google.maps.LatLng(1.042126, 120.817032)
  	};

    peta=new google.maps.Map(document.getElementById("kotakmaps"), pilihan);    

}

var latposisi;
var lngposisi;
function klikbutton()
{
    koordinatbaolan=[{lat:0.9476697852255543,lng:120.81844372113517},{lat:0.9505018093633331,lng:120.81192058881095},{lat:0.9553934819453985,lng:120.80428165753654},{lat:0.9587404118066901,lng:120.80127758343986},{lat:0.9612292383557329,lng:120.78762813310993},{lat:0.9678372649198876,lng:120.77981754045857},{lat:0.9701543620994092,lng:120.769088704399},{lat:0.9681221346936866,lng:120.76249591982287},{lat:0.9694321963967036,lng:120.75792410466715},{lat:0.9699692475875645,lng:120.75420665772049},{lat:0.9733161631167678,lng:120.74562358887283},{lat:0.9764914388819496,lng:120.7427911761531},{lat:0.9824987091437307,lng:120.74493694336502},{lat:0.9865969143859884,lng:120.74776935608475},{lat:0.995582398979199,lng:120.74476528198807},{lat:0.9972987531579228,lng:120.74596691162674},{lat:0.9981445576815147,lng:120.74694777749028},{lat:1.0006332690098498,lng:120.74789191506352},{lat:1.0014914448924204,lng:120.74909354470219},{lat:1.0014056273142697,lng:120.75038100502934},{lat:1.001062356979213,lng:120.75218344948735},{lat:1.0021779854366983,lng:120.75252677224125},{lat:1.003808518652449,lng:120.75312758706059},{lat:1.0039801536805102,lng:120.75415755532231},{lat:1.0056106859975633,lng:120.75441504738774},{lat:1.0062114082249116,lng:120.75587416909184},{lat:1.0054390510551483,lng:120.75707579873051},{lat:1.0047525111953002,lng:120.75810576699223},{lat:1.0054390510551483,lng:120.75913573525395},{lat:1.0072412175001273,lng:120.75904990456547},{lat:1.0087859308026534,lng:120.75836325905766},{lat:1.01050227805647,lng:120.75776244423832},{lat:1.010931364728294,lng:120.75904990456547},{lat:1.0117037205946406,lng:120.7604231955811},{lat:1.011961172509247,lng:120.76231147072758},{lat:1.0129909799632517,lng:120.76359893105473},{lat:1.0133342490418875,lng:120.76557303688969},{lat:1.0147073249924865,lng:120.76668883583989},{lat:1.0163378519268071,lng:120.76814795754399},{lat:1.0179683780379367,lng:120.76909209511723},{lat:1.017710926601482,lng:120.77012206337895},{lat:1.0165094862930713,lng:120.7702937247559},{lat:1.0169385721688533,lng:120.77115203164067},{lat:1.018225829453832,lng:120.77226783059086},{lat:1.0209719766096934,lng:120.77389861367192},{lat:1.0227449956207724,lng:120.77526039339898},{lat:1.0246329693871095,lng:120.77671951510308},{lat:1.025233688079513,lng:120.7792086050689},{lat:1.025920223589978,lng:120.78083938814996},{lat:1.027894012361613,lng:120.78272766329644},{lat:1.0290954484080679,lng:120.78401512362359},{lat:1.0303827008127782,lng:120.78513092257379},{lat:1.0319274030117969,lng:120.78659004427789},{lat:1.0319274030117969,lng:120.78770584322808},{lat:1.030640151231328,lng:120.78882164217828},{lat:1.030788367166971,lng:120.79124844780517},{lat:1.0306167335649055,lng:120.79270756950928},{lat:1.0307025503671023,lng:120.79468167534424},{lat:1.0306167335649055,lng:120.79656995049072},{lat:1.0290720307302972,lng:120.79820073357178},{lat:1.0289862138842087,lng:120.79965985527588},{lat:1.029243664415541,lng:120.80266392937256},{lat:1.0294152980915736,lng:120.80498135796142},{lat:1.0290720307302972,lng:120.80772793999267},{lat:1.0305309167604058,lng:120.80841458550049},{lat:1.0341352205563417,lng:120.80892956963135},{lat:1.0362806375402618,lng:120.80867207756592},{lat:1.0405714671457167,lng:120.80755627861572},{lat:1.0422877973550044,lng:120.80772793999267},{lat:1.0434034114895359,lng:120.80635464897705},{lat:1.0449481073302824,lng:120.80644047966553},{lat:1.045634638571311,lng:120.80807126274658},{lat:1.0472651496668253,lng:120.80824292412353},{lat:1.049324741416987,lng:120.80815709343506},{lat:1.0506978018305764,lng:120.80686963310791},{lat:1.0514701480480615,lng:120.80566800346924},{lat:1.0520708616406746,lng:120.80386555901123},{lat:1.0517275967447735,lng:120.80240643730713},{lat:1.0503545367837135,lng:120.80137646904541},{lat:1.049496374001657,lng:120.80000317802978},{lat:1.0499254554221433,lng:120.79785741081787},{lat:1.0513843318111127,lng:120.79588330498291},{lat:1.053787185553469,lng:120.79502499809814},{lat:1.0561615519501348,lng:120.79590519749922},{lat:1.0593367462678376,lng:120.79667767369551},{lat:1.0613105140692614,lng:120.79719265782637},{lat:1.0643998872288196,lng:120.79684933507247},{lat:1.0667169150679363,lng:120.79642018163008},{lat:1.0691197569100819,lng:120.79667767369551},{lat:1.070063729976641,lng:120.79796513402266},{lat:1.0711793341353246,lng:120.798565948842},{lat:1.0704069928379285,lng:120.80594738805098},{lat:1.0675750730843006,lng:120.81435879552168},{lat:1.070254365481186,lng:120.82284682744444},{lat:1.0703401811947808,lng:120.82928412908018},{lat:1.0704259969059586,lng:120.83546393865049},{lat:1.0646763389561027,lng:120.84215873235166},{lat:1.0520613802917405,lng:120.84868186467588},{lat:1.0373867724045935,lng:120.85348838323057},{lat:1.0243426193400302,lng:120.84730857366026},{lat:1.007720832719436,lng:120.84314299885887},{lat:0.9923594796809944,lng:120.83953810994285},{lat:0.9728804794459899,lng:120.83722238236749},{lat:0.9593211584852877,lng:120.83181504899346},{lat:0.9511683762964288,lng:120.82469110184991},{lat:0.9497094553419726,lng:120.81962709122979}];

    var baolan = new google.maps.Polygon({paths: koordinatbaolan});

    infoWindow = new google.maps.InfoWindow;

    if (navigator.geolocation) 
    {
      navigator.geolocation.getCurrentPosition(function(position) 
      {
        titik=new google.maps.LatLng(position.coords.latitude,position.coords.longitude)

        latposisi=position.coords.latitude;
        lngposisi=position.coords.longitude;

        var resultPath =
        google.maps.geometry.poly.containsLocation(titik, baolan) ?
                // A triangle.
        halamanrute():
        konfirmasi();

      }, function() {
          handleLocationError(true, infoWindow, peta.getCenter());
      });
    } 
    else 
    {
          // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, peta.getCenter());
    }

}

function konfirmasi() 
{
    var r = confirm("Maaf, Anda berada diluar daerah Kecamatan Baolan, Kabupaten Toli-Toli. Apakah anda ingin memilih lokasi secara custom?");
    if (r == true) 
    {
      window.location.href="lihatrutecustom.php";
    }
    else
    {
      window.location.href="index.php";
    }
}

function halamanrute() 
{
    window.location.href="php/panggiljs.php?latawal="+latposisi+"&lngawal="+lngposisi;
}


function handleLocationError(browserHasGeolocation, infoWindow, pos) 
{
    var errorr=browserHasGeolocation ?
    pilihan1():
    pilihan2();
}

function pilihan1()
{
  alert('Layanan geolocation gagal, periksa pengaturan lokasi.');
  window.location.href="index.php";
}

function pilihan2()
{
  alert('Browser anda tidak mendukung layanan geolocation.');
  window.location.href="index.php";
}


