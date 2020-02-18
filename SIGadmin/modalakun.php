  <!-- Logout Modal settings-->
  <div class="modal fade" id="Modalakun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" name="Form" onsubmit="return validateFormakun()">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <script>
                $('document').ready(function () {
                $("#upload").change(function () {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
                });
            </script>
            <script src="js/modal.js"></script>

           <!-- <form action="#" id="form-akun" class="form-horizontal" enctype="multipart/form-data"> -->
           <!-- <form method="POST" name="Form" onsubmit="return validateFormakun()" action="php/crudtolis.php?action=dataakun" enctype="multipart/form-data">         -->
            <form method="POST" name="Form" onsubmit="return validateFormakun()" action="php/crudtolis.php?action=dataakun" enctype="multipart/form-data">        
              <table border="0">
                <?php 
                  require_once("php/koneksidb.php");
                  $kon=new koneksidb;
                  $koneksi=$kon->konek();
                
                  $query=mysqli_query($koneksi,"SELECT *from pengguna where nama='$nama'") or die(mysql_error($koneksi));
                  while ($rows=mysqli_fetch_array($query)) 
                  {
                    $nama=$rows['nama'];
                    $nama_p=$rows['nama_pengguna'];
                    $ks=$rows['kata_sandi'];
                    $gambarr=$rows['filefoto'];
                  }
                ?>

                <tr>
                  <td style="padding:10px;" width="32%">Nama Lengkap</td>
                  <td style="width:80%; padding:10px;"><input class="form-control" type="input" placeholder="Nama Lengkap" name="namal" value="<?php echo $nama ?>">
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;"> Nama (username)</td>
                  <td style="padding:10px;"><input class="form-control" type="input" placeholder="Nama (username)" name="nama_p" value="<?php echo $nama_p ?>"> </input>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Password</td>
                  <td style="padding:10px;"> <input class="form-control" type="password" name="pass" placeholder="Password" value="<?php echo $ks ?>"> </input>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px;">Foto</td>
                  <td style="padding:10px;">
                    <img <?php echo "src=Uploads/$gambarr"; ?> id="img" alt="your image" style="width:80px; height:80px; max-width:100%;height:auto;"><br>
                    
                    <div class="upload">
                        <span class="btn btn-default btn-file" style="background-color:#e9ecef;">
                          Browse <input class="btn btn-primary" type="file" name="file" id="upload" accept="image/jpeg, image/png">
                        </span>
                    </div>
                    <input  type="input" style="display:none;" name="gambar" value="<?php echo $gambar; ?>"> </input>
                  </td>
                  <td>
                    <label style="color:red;">*</label>
                  </td>
                </tr>
                
              </table>
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-info btn-sm" value="Simpan" name="tsimpan">
            </form>
          </div>
        </div>
      </div>

    </div>


