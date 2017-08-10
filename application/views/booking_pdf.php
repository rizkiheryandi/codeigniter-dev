<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important;
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important;
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Booking List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl Booking</th>
		<th>Nama Pelanggan</th>
		<th>No Kamar</th>
		<th>Lama</th>

            </tr><?php
            foreach ($booking_data as $booking)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $booking->tgl_booking ?></td>
		      <td><?php echo $booking->nama_pelanggan ?></td>
		      <td><?php echo $booking->no_kamar ?></td>
		      <td><?php echo $booking->lama ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
<?php

