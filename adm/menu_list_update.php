<?php
$sub_menu = "100290";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();

$me_id		= $_POST['me_id'];
$me_name	= $_POST['me_name'];
$me_link	= $_POST['me_link'];

if(!$me_id || !$me_name || !$me_link)
	continue;

if($me_id){

    $sql = "	update {$g5['menu_table']}
				set 
                    me_name         = '$me_name',
                    me_link         = '$me_link',
                    me_target       = '{$_POST['me_target']}',
                    me_order        = '{$_POST['me_order']}',
                    me_use          = '{$_POST['me_use']}',
                    me_mobile_use   = '{$_POST['me_mobile_use']}' 
				where me_id='$me_id' ";

	sql_query($sql);
}

?>
<script type="text/javascript">
	parent.location.reload();
</script>
