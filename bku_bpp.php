<?php
  $page_title = 'Detail BKU';
  require_once('includes/load.php');
   //page_require_level(3);
?>


<?php 
    include_once('layouts/header.php'); 
    $user=find_by_id('users',$_SESSION['user_id']);
    $satker = find_all_global('satker',$user['id_satker'],'id');

    
  if(isset($_POST['update_nominal'])){
    $req_fields = array('nominal', 'id' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape($_POST['id']);
          $nominal     = $db->escape($_POST['nominal']);
          
          $sql  = "UPDATE pencairan SET";
          $sql .= " pengembalian='{$nominal}'";
          $sql .= " WHERE id ='{$p_id}'";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1){
                   //$h= update_product_qty_ok($p_id);
                      $session->msg('s',"SP2D updated.");
                    redirect("bku_bpp.php?id=". $p_id, false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('bku_bpp.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('bku_bpp.php',false);
        }
  }

  if(isset($_POST['update_tanggal'])){
    $req_fields = array('tanggal', 'id' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape($_POST['id']);
          $tanggal     = $db->escape($_POST['tanggal']);
          
          $sql  = "UPDATE pencairan SET";
          $sql .= " tanggal_pengembalian='{$tanggal}'";
          $sql .= " WHERE id ='{$p_id}'";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1){
                   //$h= update_product_qty_ok($p_id);
                      $session->msg('s',"SP2D updated.");
                    redirect("bku_bpp.php?id=". $p_id, false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('bku_bpp.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('bku_bpp.php',false);
        }
  }
  
?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon "></span>
            <span>SPTB</span>
          </div>
        </div>
        <div class="panel-body" style="width:100%;">
          <div class="row" style="width:100%; margin-left:2px">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th class="text-center" >No SPTJB/SPM </th>
                        <th class="text-center" style="width: 100px;"> Jumlah </th>
                    </tr>
                    </thead>
                <tbody>
                    <?php
                   
                        $sales= find_sptb_tahun($satker[0]['tahun'],$user['id_satker']);
                      
                    $tot1=0; foreach ($sales as $sale):?>
                    <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td class="text-center" >
                    <?php echo $sale['SPM'];?>/<?php echo $sale['no_sptjb'];?>
                    </td>
                    <td class="text-center">    
                        <?php echo rupiah($sale['nominal'])?>
                    </td>
                    </tr>
                    <?php $tot1+=$sale['nominal']; endforeach;?>
                </tbody>
                  <tr>
                        <th class="text-center">#</th>
                        <th class="text-center" > </th>
                        <th class="text-center"><?=rupiah($tot1);?></th> 
                  </tr>
                  
                </table>
                    
          </div>
        </div>
      </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Pencaitan</span>
      </div>
      <div class="panel-body" style="width:100%">
        <div class="row" style="width:100%; margin-left:2px">
            <table id="example1" class="table table-bordered table-striped" >
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tanggal Pencairan </th>
                            <th class="text-center"> Jumlah </th>
                            <th class="text-center">Tanggal Pengembalian </th>
                            <th class="text-center"> Jumlah </th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php
                          
                            $pencairan= find_pencairan_tahun($satker[0]['tahun'],$user['id_satker']);
                        
                        $tot=0; $tot_pengmbalian=0; foreach ($pencairan as $sale):?>
                        <tr>
                            <td class="text-center"><?php echo $sale['spm'];;?></td>
                            <td class="text-center" >
                                <?php echo $sale['tanggal'];?>
                            </td>
                            <td class="text-center">    
                                <?php echo rupiah($sale['nominal'])?>
                            </td>
                            <td class="text-center" >
                                    <?php if($sale['tanggal_pengembalian'] == ''){?>
                                        <a href="#" class="btn btn-primary" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>'>Input Tanggal Pengembalian</a>
                                    <?php }else{?>
                                        <a href="#" class="btn btn-warning" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>' data-sp2d='<?=$sale['tanggal_pengembalian'];?>'><?=$sale['tanggal_pengembalian'];?></a> 
                                    <?php } ?>
                            </td>
                            <td class="text-center">
                                  <?php if($sale['pengembalian'] == 0){?>
                                        <a href="#" class="btn btn-primary" id="editsp2d" data-toggle="modal" data-target="#exampleModal1" data-id='<?=$sale['id'];?>'>Input Pengembalian</a>
                                    <?php }else{?>
                                        <a href="#" class="btn btn-warning" id="editsp2d" data-toggle="modal" data-target="#exampleModal1" data-id='<?=$sale['id'];?>' data-sp2d='<?=$sale['pengembalian'];?>'><?=rupiah($sale['pengembalian']);?></a> 
                                    <?php } ?>
                                
                            </td>
                        </tr>
                        <?php $tot+=$sale['nominal']; $tot_pengmbalian+=$sale['pengembalian']; endforeach;?>
                    </tbody>
                    <tr>
                            <th class="text-center">#</th>
                            <th class="text-center" > </th>
                            <th class="text-center"><?=rupiah($tot);?></th> 
                            <th class="text-center" > </th>
                            <th class="text-center"><?=rupiah($tot_pengmbalian);?></th>
                    </tr>
                    <tr>
                            <th class="text-center"></th>
                            <th class="text-center" > Saldo Akhir</th>
                            <th class="text-center"><?php $uang=$tot-$tot_pengmbalian; $saldo=$uang-$tot1;?></th> 
                            <th class="text-center" > </th>
                            <th class="text-center"><?=rupiah($saldo);?></th>
                    </tr>
                </table>
        </div>
      </div>
    </div>
  </div>
</div>


  <!-- Modal input sp2d-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tanggal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Masukkan Tanggal</label>
        <input type="date" class="form-control" id="sp2d" name="tanggal" placeholder="tanggal">
        <input type="hidden" class="form-control" id="id" name="id" >
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="update_tanggal" value="Save">
      </div>
      </form>
    </div>
  </div>
</div>



  <!-- Modal edit sp2d-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nominal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Edit Nominal</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="nominal" placeholder="nominal">
        <input type="hidden" class="form-control" id="id" name="id" >
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="update_nominal" value="Update">
      </div>
      </form>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
