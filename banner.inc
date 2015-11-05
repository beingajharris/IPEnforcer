<?
global $IPfile;
$IPfile = $_SERVER["DOCUMENT_ROOT"]."\\bannedlist.txt";

function printform(){
?>
<html>
 <Head>
  <title>
   IP Banner
  </title>
 </head>
 <body bgcolor="#E60000">
  <form name=form1 action="<?=$_SERVER["PHP_SELF"]; ?>?ipbanmode=admin" method=post>
  <table align=center>
   <tr>
    <th colspan=2 align=center>
     Administration
    </th>
   </tr>
    <td>
     Username:
    </td>
    <td>
     <input type=text name="username" size=20>
    </td>
   </tr>
    <td>
     Password:
    </td>
    <td>
     <input type=password size=20 name=password>
    </td>
   </tr>
   <tr>
    <td align=center>
     <input type=submit value=Submit>
    </td>
    <td align=center>
     <input type=reset value=Reset>
    </td>
   </tr>
  </table>
  </form>
 </body>
</html>
<?
}

function isvalid($s){
     return ($s==md5("Adam"."passw0rd"));
}

function readips(){
   global $IPfile;
   clearstatcache();
   $file = fopen($IPfile,"r+");
   $bannedIps = explode("|",fread($file,filesize($IPfile)));
   fclose($file);

   return $bannedIps;
}

function RemoveArrayItem($ar,$n){
  $ar2 = array();
  foreach($ar as $k => $s){
   if ($k!=$n) {array_push($ar2,$s);}
  }
  return $ar2;
}

function rewritefile($data){
   global $IPfile;
   $file= fopen($IPfile,"w+");
   fwrite($file,implode("|",$data));
   fclose($file);
}

function writeip($ip1,$ip2,$ip3,$ip4){
   global $IPfile;
   $file= fopen($IPfile,"a+");
   clearstatcache();
   if (filesize($IPfile)!=0){
    fwrite($file,"|".$ip1.".".$ip2.".".$ip3.".".$ip4);
   }
   else
   {
    fwrite($file,$ip1.".".$ip2.".".$ip3.".".$ip4);
   }
   fclose($file);
}

function displayIPS(){
   global $IPfile;
  $ips = readips();
   clearstatcache();
  if (filesize($IPfile)!=0){
   echo "<table>\n";
   foreach($ips as $key => $s){
    echo "<tr><td><input type=button onclick=\"dodelete('".$key."');\" value=\"Delete\"></td><td>".$s."</td></tr>";
   }
   echo "</table>\n";
  }
  else
  {
   echo "There currently aren't any banned IP's in the Banned IP File protocol.\n<br>";
  }
}

function actionpage(){
?>
<html>
 <Head>
  <title>
   IP Banner
  </title>
  <script>
   <!--
    function dodelete(val){
     document.form1.delindex.value=val;
     document.form1.submit();
    }

    function correct(ID){
     if (((window.event.keyCode>=48)&&(window.event.keyCode<=57))|| (window.event.keyCode==13)){
      window.event.returnValue=true;
     }
     else{
      if (window.event.keyCode==46){
       document.getElementById(ID).focus();
      }
       window.event.returnValue=false;
    }
    }
   -->
  </script>
 </head>
 <body bgcolor="#0099FF">
  <form name=form1 action="<?=$_SERVER["PHP_SELF"]; ?>?ipbanmode=delete" method=post>
   <input type=hidden value="" name=delindex>
<? displayIPS(); ?>
   <br>
  </form>
  <form name=form2 action="<?=$_SERVER["PHP_SELF"]; ?>?ipbanmode=add" method=post>
   <input type=text MAXLENGTH=3 onkeypress="correct('IP2');" value="" ID=IP1 name=ip1 size=3><b><font size=+5>.</font></b><input type=text MAXLENGTH=3 onkeypress="correct('IP3');" value="" ID=IP2 name=ip2 size=3><b><font size=+5>.</font></b><input type=text MAXLENGTH=3 onkeypress="correct('IP4');" value="" ID=IP3 name=ip3 size=3><b><font size=+5>.</font></b><input type=text MAXLENGTH=3 onkeypress="correct('IP5');" value="" ID=IP4 name=ip4 size=3>&nbsp;<input type=submit value=add id=IP5>
  </form>
  <input type=button value=Logout onclick="window.location='<?=$_SERVER["PHP_SELF"]; ?>?ipbanmode=logout'"
 </body>
</html>
<?
}

?>