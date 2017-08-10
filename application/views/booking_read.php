
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                <h3 class='box-title'>Booking Read</h3>
        <table class="table table-bordered">
	    <tr><td>Tgl Booking</td><td><?php echo $tgl_booking; ?></td></tr>
	    <tr><td>Id Pelanggan</td><td><?php echo $id_pelanggan; ?></td></tr>
	    <tr><td>Id Kamar</td><td><?php echo $id_kamar; ?></td></tr>
	    <tr><td>Lama</td><td><?php echo $lama; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('booking') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->