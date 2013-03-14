<?php
/*
 * 74cms 个人会员中心
 * ============================================================================
 * 版权所有: 骑士网络，并保留所有权利。
 * 网站地址: http://www.74cms.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/
define('IN_QISHI', true);
require_once(dirname(__FILE__) . '/personal_common.php');
$smarty->assign('leftmenu',"index");
if ($act=='index')
{
	$smarty->assign('title','个人会员中心 - '.$_CFG['site_name']);
	$smarty->assign('user',$user);
	$smarty->assign('count_resume',count_resume($_SESSION['uid']));
	$smarty->assign('count_interview',count_interview($_SESSION['uid']));
	$smarty->assign('count_apply',count_personal_jobs_apply($_SESSION['uid']));
	$smarty->assign('count_library',count_jobs_library($_SESSION['uid']));
	$smarty->assign('userprofile',get_userprofile($_SESSION['uid']));
	$smarty->assign('interest_id',get_interest_jobs_id($_SESSION['uid']));
	$smarty->assign('rand',rand(1,100));
	$smarty->assign('notice',get_notice(0,6," WHERE type_id=3 AND is_display=1"));	
	$smarty->display('member_personal/personal_index.htm');
}
unset($smarty);
?>