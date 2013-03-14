<?php

	define('IN_QISHI', true);
	$alias="QS_index";
	require_once(dirname(__FILE__).'/include/common.inc.php');
	require_once(QISHI_ROOT_PATH.'include/mysql.class.php');
	$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);
	unset($dbhost,$dbuser,$dbpass,$dbname);
	$key=iconv("utf-8","gbk",trim($_GET['key']));
	echo $key;
	$akey=explode(' ',$key);
	if (count($akey)>1)
	{
	$akey=array_filter($akey);
	$akey=array_slice($akey,0,2);
	$akey=array_map("fulltextpad",$akey);
	$key='+'.implode(' +',$akey);
	$mode=' IN BOOLEAN MODE';
	}
	else
	{
	$key=fulltextpad($key);
	$mode=' ';
	}
	$wheresql.=" AND  MATCH (`key`) AGAINST ('{$key}'{$mode}) ";
	$orderbysql=" order by ";
	$jobstable=table('jobs_search_key');

	$wheresql=" WHERE ".ltrim(ltrim($wheresql),'AND');
	$limit=" LIMIT 0 , 8";
	$list = $id = array();
	$idresult = $db->query("SELECT id FROM {$jobstable} ".$wheresql.$limit);
	echo "SELECT id FROM {$jobstable} ".$wheresql.$orderbysql.$limit;
	while($row = $db->fetch_array($idresult))
	{
		$id[]=$row['id'];
	}
	if (!empty($id))
	{
	$wheresql=" WHERE id IN (".implode(',',$id).") ";
	$result = $db->query("SELECT * FROM ".table('jobs').$wheresql.$orderbysql);	
	echo "SELECT * FROM ".table('jobs')." ".$wheresql.$orderbysql;
		while($row = $db->fetch_array($result))
		{
		$row['jobs_name_']=$row['jobs_name'];
		if (!empty($row['highlight']))
			{
			$row['jobs_name_']="<span style=\"color:{$row['highlight']}\">{$row['jobs_name_']}</span>";
			}
		$row['refreshtime_cn']=daterange(time(),$row['refreshtime'],'Y-m-d',"#FF3300");
		$row['jobs_name']=cut_str($row['jobs_name'],$aset['jobslen'],0,$aset['dot']);
			if (!empty($row['highlight']))
			{
			$row['jobs_name']="<span style=\"color:{$row['highlight']}\">{$row['jobs_name']}</span>";
			}
			if ($aset['brieflylen']>0)
			{
				$row['briefly']=cut_str(strip_tags($row['contents']),$aset['brieflylen'],0,$aset['dot']);
			}
			else
			{
				$row['briefly']=strip_tags($row['contents']);
			}
		$row['briefly_']=strip_tags($row['contents']);
		$row['amount']=$row['amount']=="0"?'Èô¸É':$row['amount'];
		$row['companyname_']=$row['companyname'];
		$row['companyname']=cut_str($row['companyname'],$aset['companynamelen'],0,$aset['dot']);
		$row['jobs_url']=url_rewrite($aset['jobsshow'],array('id0'=>$row['id'],'addtime'=>$row['addtime']));
		$row['company_url']=url_rewrite($aset['companyshow'],array('id0'=>$row['company_id'],'addtime'=>$row['company_addtime']));
		if ($row['tag'])
		{
			$tag=explode('|',$row['tag']);
			$taglist=array();
			if (!empty($tag) && is_array($tag))
			{
				foreach($tag as $t)
				{
				$tli=explode(',',$t);
				$taglist[]=array($tli[0],$tli[1]);
				}
			}
			$row['tag']=$taglist;
		}
		else
		{
		$row['tag']=array();
		}
		$list[] = $row;
		}
	}
	else
	{
	$list=array();
	}
	print_r($list);
?>