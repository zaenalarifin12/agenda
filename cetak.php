<?php
session_start();
$hasilAsli = $_SESSION["hasil"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Cetak</title>
  <style type="text/css" media="print">
    @page { size: landscape; }
  </style>
</head>
<body>
  
  <table border="1px">
    <thead>
      <th>KECAMATAN  </th>
      <th>KELURAHAN  </th>
      <th>THN </th>
      <th>BUNDEL  </th>
      <th>NO URUT </th>
      <th>TGL SELESAI </th>
      <th>TGL PENYERAHAN  </th>
      <th>OP_BARU </th>
      <th>BETUL </th>
      <th>BATAL </th>
      <th>JUMLAH  <th>
      <th>TGL_SERAH  <th>
      <th>TGL_SERAH  <th>
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
        <td style="text-align: center">  <td>
        <td style="text-align: center">  <td>
      </tr>

    <?php
    endforeach;
    ?>
    </tbody>
  </table>

  <script>
  		window.print();
  </script>
</body>
</html>