
<style>
/* The container */
.container {
  position: relative;
  padding-left: 35px;
  /*margin-bottom: 12px;*/
  cursor: pointer;
  /*font-size: 22px;*/
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  /*background-color: #138496;*/
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

/*groupbox*/
fieldset.groupbox-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    /*margin: 1.2em 1.2em 1.2em 1.2em !important;*/
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
    display:inline;
    margin-top: 0px;
}

legend.groupbox-border {
    font-size: 1em !important;
    /*font-weight: bold !important;*/
    text-align: left !important;
    width:auto;
    padding:0px 10px 0px 10px;
    border-bottom:none;
    
}
</style>
         
<!-- Modal settings-->
         
<div class="modal fade"  id="Modalpemblokiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" id="md1" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pemblokiran Akses Jalan</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <fieldset class="groupbox-border">
            <legend class="groupbox-border">
              <label class="container">Pemblokiran dengan memilih jalan
                <input type="radio" checked="checked" name="pilih" value="jalan">
                <span class="checkmark"></span>
              </label>
            </legend>
            <div class="control-group">
                <button onclick="tampilpoly1()" id="d1" class="btn btn-info btn-sm">Jalan 1</button>
                <button onclick="tampilpoly2()" id="d2" class="btn btn-info btn-sm">Jalan 2</button>
                <button onclick="tampilpoly3()" id="d3" class="btn btn-info btn-sm">Jalan 3</button>
                <button onclick="tampilpoly4()" id="d4" class="btn btn-info btn-sm">Jalan 4</button>
            </div>
          </fieldset>
          <fieldset class="groupbox-border">
            <legend class="groupbox-border">
              <label class="container">Pemblokiran dengan menggambar daerah banjir
                <input type="radio" name="pilih" value="gambar">
                <span class="checkmark"></span>
              </label>
            </legend>
            
              <div class="control-group"> 
                <button onclick="tambah_poligon()" id="d5" disabled class="btn btn-info btn-sm">Gambar</button>
              </div>
          </fieldset>
           
          </table>

          <div id="kotakpemblokiran" style="margin-top:10px; margin-bottom:10px; width:100%; height:500px; border:1px solid grey;">
                        
          </div>

          <textarea rows="4" cols="50" id="txt" name="txtt" style="display:none"></textarea>
   
        </div>

        </div>
      </div>
      </div>
      </div>


</div>




<script>

  function batal()
  {
    window.location='pemblokiranjalan.php';
  }

  function checkDisabled(evt) 
  {
    var val = $("input[name=pilih]:checked").val();
    if (val == 'jalan') 
    {
      document.getElementById('d1').disabled=false;
      document.getElementById('d2').disabled=false;
      document.getElementById('d3').disabled=false;
      document.getElementById('d4').disabled=false;
      document.getElementById('d5').disabled=true;
      hapusgambar();
    } 
    else 
    {
      // hapus line rute
      for (var i = 0; i < gariss.length; i++) 
      {
        gariss[i].setMap(null);
      };
      gariss=[];

      //hapus simpul
      simpul=[];
      document.getElementById('d1').disabled=true;
      document.getElementById('d2').disabled=true;
      document.getElementById('d3').disabled=true;
      document.getElementById('d4').disabled=true;
      document.getElementById('d5').disabled=false;
    }
  }
  $('input[name=pilih]:radio').change(checkDisabled);
  // checkDisabled();
</script>

















