<?php
$sub_menu = "100290";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();

$count = count($_POST['me_id']);

for ($i=0; $i<$count; $i++)
{
    $_POST = array_map_deep('trim', $_POST);

	$me_id		= $_POST['me_id'][$i];
    $me_code	= $_POST['code'][$i];

    if(!$me_id || !$me_code)
        continue;

    // 메뉴 수정
    $sql = " update {$g5['menu_table']}
                set 
                    me_name         = '{$_POST['me_name'][$i]}',
                    me_link         = '{$_POST['me_link'][$i]}',
                    me_target       = '{$_POST['me_target'][$i]}',
                    me_order        = '{$_POST['me_order'][$i]}',
                    me_use          = '{$_POST['me_use'][$i]}',
                    me_mobile_use   = '{$_POST['me_mobile_use'][$i]}'
			where me_id='$me_id' ";
    sql_query($sql);

}

goto_url('./menu_list.php');
?>
