function validateFormakun()
{
  var a=document.forms["Form"]["namal"].value;
  var b=document.forms["Form"]["nama_p"].value;
  var c=document.forms["Form"]["pass"].value;
                 
  if ((a==null || a=="") && (b==null || b=="") && (c==null || c==""))
  {
    alert("Semua data masih kosong, silahkan lengkapi data");
    return false;
  }
  else if (a==null || a=="" )
  {
    alert("Nama lengkap masih kosong, silahkan lengkapi data");
    return false;
  }
  else if (b==null || b=="" )
  {
    alert("Nama pengguna (username) masih kosong, silahkan lengkapi data");
    return false;
  }
  else if (c==null || c=="" )
  {
    alert("Password masih kosong, silahkan lengkapi data");
    return false;
  }
}

function validateFormlokasibanjir()
{
  // alert("Lokasi banjir masih kosong, silahkan lengkapi data");
  var a=document.forms["Formban"]["lokasi_banjir"].value;
                 
  if (a==null || a=="" )
  {
    alert("Lokasi banjir masih kosong, silahkan lengkapi data");
    return false;
  }
 
 
}

function validateFormlokasibanjirubah()
{
  // alert("Lokasi banjir masih kosong, silahkan lengkapi data");
  var a=document.forms["Formban_u"]["lokasi_banjir"].value;
                 
  if (a==null || a=="" )
  {
    alert("Lokasi banjir masih kosong, silahkan lengkapi data");
    return false;
  }
 
 
}


function validateFormlokasievakuasi()
{
  // alert("Lokasi banjir masih kosong, silahkan lengkapi data");
  var a=document.forms["Formevk"]["latitude"].value;
  var b=document.forms["Formevk"]["longitude"].value;
  
  if ((a==null || a=="") && (b==null || b=="" ))
  {
    alert("Latitude dan longitude masih kosong, silahkan lengkapi data");
    return false;
  }   
  else if (a==null || a=="" )
  {
    alert("Latitude masih kosong, silahkan lengkapi data");
    return false;
  }
  else if (b==null || b=="" )
  {
    alert("Longitude masih kosong, silahkan lengkapi data");
    return false;
  }
 
 
}


function validateFormlokasievakuasiubah()
{
  // alert("Lokasi banjir masih kosong, silahkan lengkapi data");
  var a=document.forms["Formevk_u"]["latitude"].value;
  var b=document.forms["Formevk_u"]["longitude"].value;
  
  if ((a==null || a=="") && (b==null || b=="" ))
  {
    alert("Latitude dan longitude masih kosong, silahkan lengkapi data");
    return false;
  }   
  else if (a==null || a=="" )
  {
    alert("Latitude masih kosong, silahkan lengkapi data");
    return false;
  }
  else if (b==null || b=="" )
  {
    alert("Longitude masih kosong, silahkan lengkapi data");
    return false;
  }
 
 
}