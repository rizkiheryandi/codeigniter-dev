<!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'>KAMAR</h3>
                      <div class='box box-primary'>
        <form action="<?php echo $action; ?>" method="post"><table class='table table-bordered'>
	    <tr><td>No Kamar <?php echo form_error('no_kamar') ?></td>
            <td><input type="text" class="form-control" name="no_kamar" id="no_kamar" placeholder="No Kamar" value="<?php echo $no_kamar; ?>" />
        </td>
	    <tr><td>Nama Kamar <?php echo form_error('nama_kamar') ?></td>
            <td><input type="text" class="form-control" name="nama_kamar" id="nama_kamar" placeholder="Nama Kamar" value="<?php echo $nama_kamar; ?>" />
        </td>
	    <tr><td>Tipe Kamar <?php echo form_error('tipe_kamar') ?></td>
            <td>
            <?php echo cmb_dinamis('tipe_kamar','tipe_kamar','tipe_kamar','tipe_kamar', $tipe_kamar) ?>
            <!-- <input type="text" class="form-control" name="tipe_kamar" id="tipe_kamar" placeholder="Tipe Kamar" value="<?php // echo $tipe_kamar; ?>" /> -->
        </td>
	    <tr><td>Harga Kamar <?php echo form_error('harga_kamar') ?></td>
            <td><input type="text" class="form-control" name="harga_kamar" id="harga_kamar" placeholder="Harga Kamar" value="<?php echo $harga_kamar; ?>" />
        </td>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" />
	    <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
	    <a href="<?php echo site_url('kamar') ?>" class="btn btn-default">Cancel</a></td></tr>

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
