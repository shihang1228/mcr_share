<?php
    include_once('db_fns.php');
	header("Content-Type: text/html; charset=utf-8");
	$conn = db_connect();
	$filtervalue="";
    $noconnect ="<p>对不起，没有查找到您要查找的内容！</p>";
	$pagesize=30;
    $num=$_POST['num'];
	
	
	$areavalue =$_POST['areaselect'];
	$kindvalue =$_POST['kindselect'];
	$stuffvalue =$_POST['stuffselect'];
		
		
		if($areavalue != 0){
			$areafilter =" and p.portid =".$areavalue;
			$filtervalue =$areafilter;
		}
		if($kindvalue !=0){
			$kindfilter =" and p.kindid =".$kindvalue;
			if (strlen(($filtervalue))>0){
				$filtervalue =$filtervalue.$kindfilter;
			}
			else {
			 $filtervalue =$kindfilter;	
			}
		
		}
		if($stuffvalue !=0){
			$stufffilter =" and p.stuffid =".$stuffvalue;
			if (strlen(($filtervalue))>0){
				$filtervalue =$filtervalue.$stufffilter;
			}
			else {
				$filtervalue =$stufffilter;
			}
			
		}
	
	
	
	
	 $query = "select productid,carnum,kindname,stuffname,phone,portname,updatetime,productlen,diameterlen,wide,thinckness   "
           ." from t_product p,t_kind k,t_stuff s,t_port r,t_user u "
          ." where p.userid = u.userid and p.kindid = k.kindid and "
		  ." p.stuffid = s.stuffid and p.portid =r.portid ";	  
		
	if (strlen(trim($filtervalue))>0){
		$query =$query . $filtervalue;
	}
   
	$query =$query ." order by updatetime desc limit ".($num)*$pagesize.",$pagesize";
	
    $result = @$conn->query($query);
    if (!$result) {
		//echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
        echo  $noconnect;
		return;
    }
    //$result = db_result_to_array($result);
	//echo json_encode($result);
	  $temp_arr = array();
	 while($row = mysql_fetch_assoc($result)){
		 $temp_arr[] = $row;
	 }

	$json_arr = array();
	 foreach($temp_arr as $k=>$v){
		 $json_arr[]  = $v;

	 }
	 echo json_encode( $json_arr );


?>