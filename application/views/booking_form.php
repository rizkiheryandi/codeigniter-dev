<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>

<style>
  .ws-date {
    width: 100% !important;
  }
</style>

<!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'>BOOKING</h3>
                      <div class='box box-primary'>
        <form action="<?php echo $action; ?>" method="post"><table class='table table-bordered'>
	    <tr><td>Tgl Booking <?php echo form_error('tgl_booking') ?></td>
            <td><input type="date" class="form-control" name="tgl_booking" id="tgl_booking" placeholder="Tgl Booking" value="<?php echo $tgl_booking; ?>" />
        </td>
	    <tr><td>Pelanggan <?php echo form_error('id_pelanggan') ?></td>
            <td><?php echo cmb_dinamis('id_pelanggan','pelanggan','nama_pelanggan','id',$id_pelanggan) ?>
            <!-- <input type="text" class="form-control" name="id_pelanggan" id="id_pelanggan" placeholder="Id Pelanggan" value="<?php // echo $id_pelanggan; ?>" /> -->
        </td>
	    <tr><td>No Kamar <?php echo form_error('id_kamar') ?></td>
           <td><?php echo cmb_booking('id_kamar','kamar','no_kamar','id',$id_kamar) ?></td>
            <!-- <input type="text" class="form-control" name="id_kamar" id="id_kamar" placeholder="Id Kamar" value="<?php // echo $id_kamar; ?>" /> -->
        </td>
	    <tr><td>Lama <?php echo form_error('lama') ?></td>
            <td><input type="text" class="form-control" name="lama" id="lama" placeholder="Lama" value="<?php echo $lama; ?>" />
        </td>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" />
	    <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
	    <a href="<?php echo site_url('booking') ?>" class="btn btn-default">Cancel</a></td></tr>

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
