<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb">
        <ul>
            <?php if ($is_member) {  ?>

            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fa fa-cog" aria-hidden="true"></i> 정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a></li>
            <?php if ($is_admin) {  ?>
            <li  class="tnb_admin"><a href="<?php echo G5_ADMIN_URL ?>"><b><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</b></a></li>
            <?php }  ?>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php"><i class="fa fa-user-plus" aria-hidden="true"></i> 회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php"><b><i class="fa fa-sign-in" aria-hidden="true"></i> 로그인</b></a></li>
            <?php }  ?>

        </ul>
  
    </div>
    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>
    
        <div class="hd_sch_wr">
            <fieldset id="hd_sch" >
                <legend>사이트 내 전체검색</legend>
                <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sound_only">검색어 필수</label>
                <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="검색어를 입력해주세요">
                <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
                </form>

                <script>
                function fsearchbox_submit(f)
                {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i=0; i<f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
                </script>

            </fieldset>
                
            <?php echo popular(); // 인기검색어, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?>
        </div>
        <ul id="hd_qnb">
            <li><a href="<?php echo G5_BBS_URL ?>/faq.php"><i class="fa fa-question" aria-hidden="true"></i><span>FAQ</span></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php"><i class="fa fa-comments" aria-hidden="true"></i><span>1:1문의</span></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php" class="visit"><i class="fa fa-users" aria-hidden="true"></i><span>접속자</span><strong class="visit-num"><?php echo connect(); // 현재 접속자수, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?></strong></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/new.php"><i class="fa fa-history" aria-hidden="true"></i><span>새글</span></a></li>
        </ul>
    </div>
    
   
    
    
    
    <div class="navbar navbar-navs">
            <div class="container">
                <nav class="main-navigation">
                    <ul id="menu-primary-1" class="menu">
                        <?php
				$sql = " select *
							from {$g5['menu_table']}
							where me_use = '1'
							  and length(me_code) = '2'
							order by me_order, me_id ";
				$result = sql_query($sql, false);
				for ($i=0; $row=sql_fetch_array($result); $i++) {

					$sql2 = " select *
								from {$g5['menu_table']}
								where me_use = '1'
								  and length(me_code) = '4'
								  and substring(me_code, 1, 2) = '{$row['me_code']}'
								order by me_order, me_id ";
					$result2 = sql_query($sql2);

					$row['cnt'] = @sql_num_rows($result2);

				?>
                        <li class="menu-item<?php echo ($row['cnt'])?' menu-item-has-children':'';?>"> <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>"><?php echo $row['me_name'] ?></a>
                            <?php
					for ($k=0; $row2=sql_fetch_array($result2); $k++) {

							$sql3 = " select *
										from {$g5['menu_table']}
										where me_use = '1'
										  and length(me_code) = '6'
										  and substring(me_code, 1, 4) = '{$row2['me_code']}'
										order by me_order, me_id ";
							$result3 = sql_query($sql3);

							$row2['cnt'] = @sql_num_rows($result3);

						if($k == 0)
							echo '<ul class="sub-menu2">'.PHP_EOL;
					?>
                        <li class="menu-item<?php echo ($row2['cnt'])?' menu-item-has-children':'';?>"> <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a>
                            <?php
							for ($s=0; $row3=sql_fetch_array($result3); $s++) {

									$tql4 = " select *
												from {$g5['menu_table']}
												where me_use = '1'
												  and length(me_code) = '8'
												  and substring(me_code, 1, 6) = '{$row3['me_code']}'
												order by me_order, me_id ";
									$result4 = sql_query($tql4);

									$row3['cnt'] = @sql_num_rows($result4);

								if($s == 0)
									echo '<ul class="sub-menu3">'.PHP_EOL;
							?>
                        <li class="menu-item<?php echo ($row3['cnt'])?' menu-item-has-children':'';?>"> <a href="<?php echo $row3['me_link']; ?>" target="_<?php echo $row3['me_target']; ?>"><?php echo $row3['me_name'] ?></a>
                            <?php
									for ($t=0; $row4=sql_fetch_array($result4); $t++) {
										if($t == 0)
											echo '<ul class="sub-menu4">'.PHP_EOL;
									?>
                        <li class="menu-item"> <a href="<?php echo $row4['me_link']; ?>" target="_<?php echo $row4['me_target']; ?>"><?php echo $row4['me_name'] ?></a> </li>
                        <?php
									}

									if($t > 0)
										echo '</ul>'.PHP_EOL;
									?>
                        </li>
                        <?php
							}

							if($s > 0)
								echo '</ul>'.PHP_EOL;
							?>
                        </li>
                        <?php
					}

					if($k > 0)
						echo '</ul>'.PHP_EOL;
					?>
                        </li>
                        <?php
				}

				if ($i == 0) {  ?>
                        <li class="menu-item">
                            <?php if ($is_admin) { ?>
                            <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>
                            <?php }else{ ?>
                            <a href="<?php echo G5_URL ?>">메뉴 준비 중입니다.</a>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>

    
    
   
    
    
    
    
    <script>
    
    $(function(){
        $(".gnb_menu_btn").click(function(){
            $("#gnb_all").show();
        });
        $(".gnb_close_btn").click(function(){
            $("#gnb_all").hide();
        });
    });

    </script>
</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
   
    <div id="container">
        <?php if (!defined("_INDEX_")) { ?><h2 id="container_title"><span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span></h2><?php } ?>

