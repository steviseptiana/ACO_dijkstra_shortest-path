
<script src="js/modal.js"></script>
         
<!-- Modal settings-->
<div class="modal fade" id="Modallokasibanjir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" name="Form" onsubmit="return validateFormakun()">
	<div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Lokasi Banjir</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
           
            <?php
            	require_once('php/koneksidb.php');
      				$kon=new koneksidb;
      				$koneksi=$kon->konek();

                $cek="SELECT * from lokasibanjir";
                $cek2=mysqli_query($koneksi,$cek);
                $cek3=mysqli_num_rows($cek2);
                                      
                if ($cek3>0)
                {                        
                    $sqll="SELECT MAX(id_lokbanjir) from lokasibanjir ";
                    $hasill = mysqli_query($koneksi,$sqll);
                    $dataa = mysqli_fetch_array($hasill);
                    $maxid=$dataa[0];
                    $maxid++;
                    $no=$maxid++; 
                }
                else
                {
                    $no='BNJ_0001';
                }
            ?>

           <!-- <form action="#" id="form-akun" class="form-horizontal" enctype="multipart/form-data"> action="php/crudtolis.php?action=datalokasibanjir"-->
           <!-- <form method="POST" name="Form" onsubmit="return validateFormakun()" action="php/crudtolis.php?action=dataakun" enctype="multipart/form-data">         -->
            <form method="POST" name="Formban" onsubmit="return validateFormlokasibanjir()" action="php/crudtolis.php?action=datalokasibanjir">        
              <table border="0">
                <tr>
                  <td style="padding:10px;" width="25%">ID Banjir</td>
                  <td style="width:80%; padding:10px;"><input class="form-control" type="input" name="id_banjir" value="<?php echo $no;?>" readonly>
                  </td>
                  <td>
                  	<label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Lokasi Banjir</td>
                  <td style="padding:10px;">
                  	<input class="form-control" type="input" name="lokasi_banjir" placeholder="Lokasi Banjir"> </input>
                  </td>
                  <td>
                  	<label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Keterangan</td>
                  <td style="padding:10px;"> <textarea class="form-control" name="ket" placeholder="Keterangan"></textarea></td>
                </tr>
                <tr>
                  	<td style="padding:10px;">Status</td>
                  	<td style="padding:10px;">
	                  	<table>
		                  	<tr>
			                  <td style="padding:8px;">
			                  	<input type="radio" name="pilihstatusbanjir" value="Aktif" checked/> Aktif
			                  </td>
			                  <td>
			                  	<input type="radio" name="pilihstatusbanjir" value="Tidak Aktif"/> Tidak Aktif
			                  </td>
			                 </tr>
		                  </table>
              			</td>
	                <td>
	                  	<label style="color:red;">*</label>
	                </td>
                </tr>
                
              </table>
          </div>
          <div class="modal-footer">
              <input type="submit"  class="btn btn-info btn-sm" value="Simpan" name="tsimpan">
            </form>
          </div>
        </div>
    </div>

</div>






<!-- Modal settings-->
<div class="modal fade" id="ubahModallokasibanjir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" name="Form" onsubmit="return validateFormakun()">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Data Lokasi Banjir</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
             <form method="POST" name="Formban_u" onsubmit="return validateFormlokasibanjirubah()" action="php/crudtolis.php?action=datalokasibanjir">        
              <table border="0">
                <tr>
                  <td style="padding:10px;" width="25%">ID Banjir</td>
                  <td style="width:80%; padding:10px;"><input class="form-control" type="input" id="id_banjir" name="id_banjir" readonly>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Lokasi Banjir</td>
                  <td style="padding:10px;">
                    <input class="form-control" id="lokasi_banjir" type="input" name="lokasi_banjir" placeholder="Lokasi Banjir"> </input>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Keterangan</td>
                  <td style="padding:10px;"> <textarea id="ket" class="form-control" name="ket" placeholder="Keterangan"></textarea></td>
                </tr>
                <tr>
                    <td style="padding:10px;">Status</td>
                    <td style="padding:10px;">
                      <table>
                        <tr>
                        <td style="padding:8px;">
                          <input type="radio" id="pilihaktif" name="pilihstatusbanjir" value="Aktif" checked/> Aktif
                        </td>
                        <td>
                          <input type="radio" id="pilihtaktif" name="pilihstatusbanjir" value="Tidak Aktif"/> Tidak Aktif
                        </td>
                       </tr>
                      </table>
                    </td>
                  <td>
                      <label style="color:red;">*</label>
                  </td>
                </tr>
                
              </table>
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-info btn-sm" value="Ubah" name="tubah">
            </form>
          </div>
        </div>
    </div>

</div>


