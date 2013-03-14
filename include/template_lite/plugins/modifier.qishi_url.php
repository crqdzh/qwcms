<?php
function tpl_modifier_qishi_url($string)
{
	if (strpos($string,","))
	{
	$val=explode(",",$string);
		if ($val[0]=="QS_user")
		{
			return get_member_url($val[1],true);
		}
		else
		{
		return url_rewrite($val[0],array('id0'=>$val[1]));
		}	
	}
	else
	{
	return url_rewrite($string);
	}
}
?>