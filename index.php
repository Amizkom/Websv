<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);
 /*
 
Creator : @AmiZkom
 */
 if (isset($_GET["id"]))//اگر ايدي وارد شود
	$id = $_GET["id"]; 
 else{//اگر ايدي وارد نشود پيام زير نمايش داده شود
	 $result = ['ok' => false,'Description' => "id not exist"];
     echo json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
     exit();
 }
	 
 
 chdir(__DIR__);  //تغيير  دايرکتوري به ادرس اين فايل
 if (!file_exists('madeline.php') || !filesize('madeline.php')) {
  copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php'); //دريافت فايل ميدلاين که کتابخانه ميدلاين را برروي محل همين فايل کپي ميکند
 }
 require 'madeline.php'; // فراخواني فايل ميدلاين
 $MadelineProto = new \danog\MadelineProto\API('session.madeline', ['logger' => ['logger_level' => 5]]); // اتصال به سشن اکانت شما
 $MadelineProto->start(); //اجرا کردن ميدلاين
 
    try {
        usleep(mt_rand(100000,300000));
        $res = $MadelineProto->get_full_info($id);
     
    }
    
    catch(Exception $e) {
        file_put_contents('e.txt',$e);
        $result = ['ok' => false];
		
        echo json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        exit();
    }
 
 $info = json_encode($res); // استفاده از متود get_full_info براي دريافت اطلاعات کامل يک کانال,گروه,فرد
 $info2 = json_decode($info,true);
 
 $type =$info2['type'];
 if ($id != ''){
    if ($type == 'user'){
        
        $id = $info2['user_id'];
        
        if($id) {
        
            $statsus= $info2['User']['status']['_'];
            $photoid= $info2['User']['photo']['photo_id'];
            $username= $info2['User']['username'];
            $firstname = $info2['User']['first_name'];
            $lastname= $info2['User']['last_name'];
            $access_hash = $info2['User']['access_hash'];
            $result= ["ok"=>true,"first_name"=>"$firstname","last_name"=>"$lastname","username"=>"$username","user_id"=>$id,"status"=>"$statsus","photo_id"=>$photoid,"access_hash"=>$access_hash];
            
        } else {
            
            $result = ['ok' => false];
            
        }
        
        echo json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }
    if ($type == 'channel'){
     $id = $info2["Chat"]['id'];
     $statsus= $info2['type'];  
     $username= $info2['Chat']['username'];
     $firstname = $info2['Chat']['title'];
     $lastname= $info2['full']['about'];
     $lastname= $info2['full']['about'];
     $status2= $info2['full']['participants_count'];
     $access_hash = $info2['Chat']['access_hash'];
     $result= ["title"=>"$firstname","about"=>"$lastname","username"=>"$username","id"=>$id,"members"=>$status2,"access_hash"=>$access_hash,"type"=>"$statsus"];
//AmiZa
 echo json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
 }
 }
