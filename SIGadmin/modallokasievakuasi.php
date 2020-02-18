
<script src="js/modal.js"></script>
         
<!-- Modal settings-->
         
<div class="modal fade"  id="Modallokasievakuasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" id="md1" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Lokasi Evakuasi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
           
            <?php
            	require_once('php/koneksidb.php');
      				$kon=new koneksidb;
      				$koneksi=$kon->konek();

                $cek="SELECT * from lokasievakuasi";
                $cek2=mysqli_query($koneksi,$cek);
                $cek3=mysqli_num_rows($cek2);
                                      
                if ($cek3>0)
                {                        
                    $sqll="SELECT MAX(id_lokevakuasi) from lokasievakuasi ";
                    $hasill = mysqli_query($koneksi,$sqll);
                    $dataa = mysqli_fetch_array($hasill);
                    $maxid=$dataa[0];
                    $maxid++;
                    $no=$maxid++; 
                }
                else
                {
                    $no='EVK_0001';
                }
            ?>
          
           <div class="row">

            <div class="col-lg-6">
           <!-- <form action="#" id="form-akun" class="form-horizontal" enctype="multipart/form-data"> action="php/crudtolis.php?action=datalokasibanjir"-->
           <!-- <form method="POST" name="Form" onsubmit="return validateFormakun()" action="php/crudtolis.php?action=dataakun" enctype="multipart/form-data">         -->
            <form method="POST" name="Formevk" onsubmit="return validateFormlokasievakuasi()" action="php/crudtolis.php?action=datalokasievakuasi">        
              <table border="0">
                <tr>
                  <td style="padding:10px;" width="25%">ID Lokasi Evakuasi</td>
                  <td style="width:80%; padding:10px;"><input class="form-control" type="input" name="id_evk" value="<?php echo $no;?>" readonly>
                  </td>
                  <td>
                  	<label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Latitude</td>
                  <td style="padding:10px;">
                  	<input class="form-control" id="lat1" type="input" name="latitude" placeholder="Latitude"> </input>
                  </td>
                  <td>
                  	<label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Longitude</td>
                  <td style="padding:10px;"> <input id="lng1" class="form-control" type="input" name="longitude" placeholder="Longitude"/></td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  	<td style="padding:10px;">Status</td>
                  	<td style="padding:10px;">
	                  	<table>
		                  	<tr>
			                  <td style="padding:8px;">
			                  	<input type="radio" name="pilihstatusevk" value="Aktif" checked/> Aktif
			                  </td>
			                  <td>
			                  	<input type="radio" name="pilihstatusevk" value="Tidak Aktif"/> Tidak Aktif
			                  </td>
			                 </tr>
		                  </table>
              			</td>
	                <td>
	                  	<label style="color:red;">*</label>
	                </td>
                </tr>
                
              </table>
            <div class="modal-footer">
              <input type="submit"  class="btn btn-info btn-sm" value="Simpan" name="tsimpan">
            </form>
          </div>

          <!--row-->
        </div>

        <div class="col-lg-6" style="padding:20px;">
              Custom Location
              <div id="kotaklokevakuasi" style="width:100%; height:500px; border:1px solid black;">
                        
              </div>
        </div>

        </div>
      </div>
      </div>
      </div>
   
</div>


<!-- Modal settings-->        
<div class="modal fade"  id="ubahModallokasievakuasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="md2" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Lokasi Evakuasi</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

           <div class="row">

            <div class="col-lg-6">
           <!-- <form action="#" id="form-akun" class="form-horizontal" enctype="multipart/form-data"> action="php/crudtolis.php?action=datalokasibanjir"-->
           <!-- <form method="POST" name="Form" onsubmit="return validateFormakun()" action="php/crudtolis.php?action=dataakun" enctype="multipart/form-data">         -->
            <form method="POST" name="Formevk_u" onsubmit="return validateFormlokasievakuasiubah()" action="php/crudtolis.php?action=datalokasievakuasi">        
              <table border="0">
                <tr>
                  <td style="padding:10px;" width="25%">ID Lokasi Evakuasi</td>
                  <td style="width:80%; padding:10px;"><input class="form-control" type="input" name="id_evk" id="id" readonly>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Latitude</td>
                  <td style="padding:10px;">
                    <input class="form-control" id="lat" type="input" name="latitude" placeholder="Latitude"> </input>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Longitude</td>
                  <td style="padding:10px;"> <input id="lng" class="form-control" type="input" name="longitude" placeholder="Longitude"/></td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                    <td style="padding:10px;">Status</td>
                    <td style="padding:10px;">
                      <table>
                        <tr>
                        <td style="padding:8px;">
                          <input type="radio" id="pilihaktifevk" name="pilihstatusevk" value="Aktif" checked/> Aktif
                        </td>
                        <td>
                          <input type="radio" id="pilihtaktifevk" name="pilihstatusevk" value="Tidak Aktif"/> Tidak Aktif
                        </td>
                       </tr>
                      </table>
                    </td>
                  <td>
                      <label style="color:red;">*</label>
                  </td>
                </tr>
                
              </table>
              <div class="modal-footer">
              <input type="submit"  class="btn btn-info btn-sm" value="Ubah" name="tubah">
            </form>
              </div>

          <!--row-->
        </div>

        <div class="col-lg-6" style="padding:20px;">
              Custom Location
              <div id="kotaklokevakuasi2" style="width:100%; height:500px; border:1px solid black;">
                        
              </div>
              <!--row-->
        </div>
            
            <!--row-->
        </div>

    </div>
</div>

















