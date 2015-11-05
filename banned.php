<?    // use10 images 0 through 9 all JPEG's and all the same size (just easesthings a bit)
  if (isset($_GET['IP'])){                                          // is it requesting an image?
    $longstr = strlen($_GET['IP']);                                  // retrieve the length of the IP address!!!
    $s = getimagesize('images/numbers/0.jpg');                       // retrieve image size
    $w = $s[0];                                                      // retrieve the image width
    $h = $s[1];                                                      // retrieve the image height

    $img = imagecreatetruecolor($w*$longstr,$h);                     // Create the true color visual

    for ($x=0; $x < $longstr; $x++)  {                               // Loop through Image string
      $image = substr($_GET['IP'],$x,1);                             // Get the image prefix
      if ($image=="."){$image="dot";}                                // Substitute dot for .

      $img2 = ImageCreateFromJpeg("images/numbers/".$image.".jpg");  // Open imagefile denoted by the prefix
      imagecopy($img,$img2,$x*$w,0,0,0,$w,$h);                       // Copy Image to new image
      imagedestroy($img2);                                           // Destroy Loaded image
    }
    imagejpeg($img);                                                 // Dump image to output
    imagedestroy($img);                                              // Destoy dumpped image to free memory
  }
  else                                                              // or else dump HTML
  {
?>
<html>
 <Head>
  <title>Banned IP: <?=$_SERVER['REMOTE_ADDR'] ?></title>
  <style>
  <!--
body, td, label{
     font-size : 12pt;
     scrollbar-face-color : #CC6600;
     scrollbar-shadow-color : #000000;
     scrollbar-highlight-color : #412100;
     scrollbar-3dlight-color : #FF952A;
     scrollbar-darkshadow-color : #1A0D00;
     scrollbar-track-color : #FFD3A7;
     scrollbar-arrow-color : #000000;
}

body.brownbar{
     background : #2D1700;
}

.scroller{
        scrollbar-face-color : #CC6600;
        scrollbar-shadow-color : #000000;
        scrollbar-highlight-color : #FCFCFC;
        scrollbar-3dlight-color : #F5F5F5;
        scrollbar-darkshadow-color : #1A0D00;
        scrollbar-track-color : #FFD3A7;
        scrollbar-arrow-color : #000000;
}

.scrollitem{
            height : 20px;
            font-size : 11pt;
            border : 1px solid;
            border-color : #0000dd #000000 #000000 #0000dd;
            color :#ffffff;
}

.scrollitem2{
            height : 20px;
            font-size : 11pt;
            border : 1px solid;
            border-color : #000000 #0000dd #0000dd #000000;
            color :#ff0000;
            cursor : hand;
}

.btn{
     background-color : #4433ab;
     color : #aaaaaa;
     border : 2px solid;
     border-color : #0000dd #000000 #000000 #0000dd;
}
input{
      background-color : #4433ab;
      color : #aaaaaa;
      border : 1px solid;
      border-color : #000000 #0000dd #0000dd #000000;
}

a.link{
      text-decoration : none;
      color : #ffffff;
}

option{
       background-color : #000066;
       color : #ffffff;
}

.edit{
              width:100px;
              font-size:10px;
}

.btn1{
      font-size:10px;
}

.small{
       font-size:10px;
}
  -->
  </style>
 </head>
 <body class=brownbar>
  <center><img src="images/banned.jpg" alt="" border=0><br>
  Sorry the IP address:<br>
  <img src="<? echo $PHP_SELF."?IP=".$_SERVER['REMOTE_ADDR'] ?>" alt="IP"><br>
  has been banned from this site.
  </center>
 </body>
</html>
<?
}
?>