<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
  $pengajuan = find_by_id('pengajuan',(int)$_GET['id']);
  $user = find_by_id('users',(int)$_SESSION['user_id']);
  if(!$pengajuan){
    $session->msg("d","Missing Pengajuan id.");

    if($user['user_level']==2){
      redirect('pengajuan_verifikator.php');  
    }else{
    redirect('pengajuan.php');
    }
  }
  $query  = "UPDATE pengajuan SET ";
        $query .= "status_verifikasi='".$_SESSION['user_id']."'";
        $query .= "WHERE id='{$pengajuan["id"]}'";
        $result = $db->query($query);
        $session->msg('s',' Berhasil di Proses');
        if($user['user_level']==2){
            redirect('pengajuan_verifikator.php');
          }else{
      redirect('pengajuan.php', false);
        }
?>