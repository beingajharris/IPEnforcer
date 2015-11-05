<?
// please place this file in the suto prepend setting in PHP.ini
// ini_set("auto_prepend_file","IPBanner.php");
require_once("banner.inc");
global $IPfile;
$IPfile = $_SERVER["DOCUMENT_ROOT"]."\\bannedlist.txt";

switch (strtoupper($_GET["ipbanmode"])){
  case "ADMIN":
   if (($username=="Adam") && ($password=="passw0rd")) {
    session_name("login");
    session_start();
    $_SESSION["Login"]=md5($username.$password);
   }

   if ($_SESSION["Login"]!=md5("Adam"."passw0rd")){
    if ($_SESSION["disp"]==0){ printform();$_SESSION["disp"]=1;}else{$_SESSION["disp"]=0;}
   }
   else{
    if ($_SESSION["disp"]==0){
     actionpage();
     $_SESSION["disp"]=1;
    }
    else{
     $_SESSION["disp"]=0;
    }
   }
   break;

  case "ADD":
   session_name("login");
   session_start();

   if (!isvalid($_SESSION["Login"])){
    if ($_SESSION["disp"]==0){ printform();$_SESSION["disp"]=1;}else{$_SESSION["disp"]=0;}
    exit;
   }

   if ($_SESSION["disp"]==0){
    writeip($ip1,$ip2,$ip3,$ip4);
    $_SESSION["disp"]=1;
   }
   else{
    $_SESSION["disp"]=0;
    actionpage();
   }
  break;

  case "LOGOUT":
   session_name("login");
   session_start();
   session_unset();
   session_destroy();
   header("Location: IPBanner.php?ipbanmode=admin");
  break;

  case "DELETE":
   session_name("login");
   session_start();

   if (!isvalid($_SESSION["Login"])){
    if ($_SESSION["disp"]==0){ printform();$_SESSION["disp"]=1;}else{$_SESSION["disp"]=0;}
    exit;
   }


   if ($_SESSION["disp"]==0){
    $bannedIps = readips();
    $bannedIps = RemoveArrayItem($bannedIps,$delindex);
    rewritefile($bannedIps);
    $_SESSION["disp"]=1;
   }
   else{
    $_SESSION["disp"]=0;
    actionpage();
   }
  break;

  Default:

if (!file_exists($IPfile)){
        $file = fopen($IPfile,"w+"); //create it
        fwrite ($file,'');           //empty it
        fclose ($file);              //close it
}

$bannedIps = readips();

 if(in_array ($_SERVER['REMOTE_ADDR'], $bannedIps)){
	 if (strtoupper(basename($PHP_SELF))!="BANNED.PHP") {header('Location: /banned.php');
	  exit;
	 }
  }
  break;
}
?>