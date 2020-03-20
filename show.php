<?php
session_start();
$hasilAsli = $_SESSION["hasil"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Tampil</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>

  <div class="container mt-3">

  <table border="1px">
  <thead>
    <th>NM_KECAMATAN  </th>
    <th>NM_KELURAHAN  </th>
    <th>THN_PELAYANAN </th>
    <th>BUNDEL_PELAYANAN  </th>
    <th>NO_URUT_PELAYANAN </th>
    <th>TGL_SELESAI </th>
    <th>TGL_PENYERAHAN  </th>
    <th>OP_BARU </th>
    <th>BETUL </th>
    <th>BATAL </th>
    <th>JUMLAH  <th>
  </thead>
  <tbody>
  <?php
  foreach($hasilAsli as $key => $value):
  ?>

    <tr>
      <td style="text-align: center"><?= $value["NM_KECAMATAN"] ?>  </td>
      <td style="text-align: center"><?= $value["NM_KELURAHAN"] ?>  </td>
      <td style="text-align: center"><?= $value["THN_PELAYANAN"] ?>  </td>
      <td style="text-align: center"><?= str_pad($value["BUNDEL_PELAYANAN"], 4, 0, STR_PAD_LEFT) ?> </td>
      <td style="text-align: center"><?= str_pad($value["NO_URUT_PELAYANAN"], 3, 0, STR_PAD_LEFT) ?> </td>
      <td style="text-align: center"><?= $value["TGL_SELESAI"] ?> </td>
      <td style="text-align: center"><?= $value["TGL_PENYERAHAN"] ?>  </td>
      <td style="text-align: center"><?= $value["OP_BARU"] ?> </td>
      <td style="text-align: center"><?= $value["BETUL"] ?> </td>
      <td style="text-align: center"><?= $value["BATAL"] ?> </td>
      <td style="text-align: center"><?= $value["JUMLAH"] ?>  <td>
    </tr>

  <?php
  endforeach;
  ?>
  </tbody>
</table>

<br>
<a href="index.php" class="btn btn-primary ml-3 mr-4">kembali</a>
<a href="cetak.php" class="btn btn-info ml-3" target="_blank">Cetak</a>

</div>
</body>
</html>
