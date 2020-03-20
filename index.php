<?php
require_once("config.php");

session_start();

if(isset($_POST["cari"])){
  
  $tahun      = $_POST["tahun"];
  $bundle     = $_POST["bundle"];
  $pelayanan  = $_POST["pelayanan"];

  $hasil[] = null;
  for($i = 0; $i < count($tahun); $i++){
    $sql =  "SELECT DISTINCT
              pst_detail.KD_KECAMATAN_PEMOHON, pst_detail.KD_KELURAHAN_PEMOHON,
              ref_kecamatan.NM_KECAMATAN, ref_kelurahan.NM_KELURAHAN,
              pst_detail.THN_PELAYANAN, pst_detail.BUNDEL_PELAYANAN, pst_detail.NO_URUT_PELAYANAN,
              pst_detail.TGL_SELESAI, pst_detail.TGL_PENYERAHAN,
              -- pst_detail.KD_JNS_PELAYANAN,pst_detail.TGL_SELESAI,
              (SELECT COUNT(pst_detail.KD_JNS_PELAYANAN) 
                  FROM pst_detail 
                      WHERE pst_detail.KD_JNS_PELAYANAN     = 1 
                          AND pst_detail.THN_PELAYANAN      = $tahun[$i] 
                          AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
                          AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
                          AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
                          AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON
              ) AS OP_BARU,

              (SELECT COUNT(*)
                  FROM pst_detail 
                      WHERE (pst_detail.KD_JNS_PELAYANAN    = 2 OR pst_detail.KD_JNS_PELAYANAN = 3) 
                          AND pst_detail.THN_PELAYANAN      = $tahun[$i] 
                          AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
                          AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
                          AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
                          AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON
              ) AS BETUL,

              (SELECT COUNT(*) 
                  FROM pst_detail 
                      WHERE pst_detail.KD_JNS_PELAYANAN     = 4 
                          AND pst_detail.THN_PELAYANAN      = $tahun[$i] 
                          AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
                          AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
                          AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
                          AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON
              ) AS BATAL,

              (
                  -- op baru
                  (SELECT COUNT(pst_detail.KD_JNS_PELAYANAN) 
                  FROM pst_detail 
                      WHERE pst_detail.KD_JNS_PELAYANAN     = 1 
                          AND pst_detail.THN_PELAYANAN      = $tahun[$i] 
                          AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
                          AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
                          AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
                          AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON)
                  +
                  -- betul
                  (SELECT COUNT(*)
                  FROM pst_detail 
                      WHERE (pst_detail.KD_JNS_PELAYANAN    = 2 OR pst_detail.KD_JNS_PELAYANAN = 3) 
                          AND pst_detail.THN_PELAYANAN      = $tahun[$i] 
                          AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
                          AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
                          AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
                          AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON)
                  +
                  -- batal
                  (SELECT COUNT(*) 
                  FROM pst_detail 
                      WHERE pst_detail.KD_JNS_PELAYANAN     = 4 
                          AND pst_detail.THN_PELAYANAN      = $tahun[$i] 
                          AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
                          AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
                          AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
                          AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON)
                          
              ) AS JUMLAH

          FROM pst_detail 

          INNER JOIN 
              ref_kecamatan 
                  ON pst_detail.KD_KECAMATAN_PEMOHON  = ref_kecamatan.KD_KECAMATAN
          INNER JOIN 
              ref_kelurahan   
                  ON ref_kecamatan.KD_KECAMATAN       = ref_kelurahan.KD_KECAMATAN

          WHERE pst_detail.THN_PELAYANAN        = $tahun[$i] 
              AND pst_detail.BUNDEL_PELAYANAN   = $bundle[$i] 
              AND pst_detail.NO_URUT_PELAYANAN  = $pelayanan[$i]
              AND ref_kelurahan.KD_KELURAHAN    = pst_detail.KD_KELURAHAN_PEMOHON   
              AND ref_kecamatan.KD_KECAMATAN    = pst_detail.KD_KECAMATAN_PEMOHON
      ";

    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_assoc($result);
      // push to array

      $hasil[$i]["KD_KECAMATAN_PEMOHON"]  =  $row["KD_KECAMATAN_PEMOHON"];
      $hasil[$i]["KD_KELURAHAN_PEMOHON"]  =  $row["KD_KELURAHAN_PEMOHON"];
      $hasil[$i]["NM_KECAMATAN"]          =  $row["NM_KECAMATAN"];
      $hasil[$i]["NM_KELURAHAN"]          =  $row["NM_KELURAHAN"];
      $hasil[$i]["THN_PELAYANAN"]         =  $row["THN_PELAYANAN"];
      $hasil[$i]["BUNDEL_PELAYANAN"]      =  $row["BUNDEL_PELAYANAN"];
      $hasil[$i]["NO_URUT_PELAYANAN"]     =  $row["NO_URUT_PELAYANAN"];
      $hasil[$i]["TGL_SELESAI"]           =  $row["TGL_SELESAI"];
      $hasil[$i]["TGL_PENYERAHAN"]        =  $row["TGL_PENYERAHAN"];
      $hasil[$i]["OP_BARU"]               =  $row["OP_BARU"];
      $hasil[$i]["BETUL"]                 =  $row["BETUL"];
      $hasil[$i]["BATAL"]                 =  $row["BATAL"];
      $hasil[$i]["JUMLAH"]                =  $row["JUMLAH"];
    }

  }
  
  
  $_SESSION["hasil"] = $hasil;
  
  header("Location: show.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Cari nomor layanan</title>
  </head>
  <body class="bg-secondary">
    <div class="container mt-3">
      <label for="">Nomor Layanan</label>
        <button class="btn btn-info" id="tambah"> Tambah Nomor</button>
        <form action="" method="post">
        <div class="input-group mt-3 wrap">
            <input type="text" minlength="4" maxlength="4" name="tahun[]" class="form-control">
            <input type="text" minlength="4" maxlength="4" name="bundle[]" class="form-control">
            <input type="text" minlength="3" maxlength="3" name="pelayanan[]" class="form-control">
        </div>
        <br>
        <input type="submit" name="cari" value="Cari" class="btn btn-lg btn-primary float-right px-5">
      </form>
    </div>

  <script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous">
  </script>

  <script>
    $(document).ready(function(){
      $("#tambah").on("click", function(){
        $(".wrap").last().append(`
        <div class="input-group mt-3 wrap">
            <input type="text" minlength="4" maxlength="4" name="tahun[]" class="form-control">
            <input type="text" minlength="4" maxlength="4" name="bundle[]" class="form-control">
            <input type="text" minlength="3" maxlength="3" name="pelayanan[]" class="form-control">
        </div>
        `);
      })
    })
  </script>
  </body>
</html>