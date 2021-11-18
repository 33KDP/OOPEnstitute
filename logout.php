<?php
session_start();

echo "
<meta http-equiv='refresh' content='3; url=index.php'>
<script src='http://cdnjs.cloudflare.com/ajax/libs/three.js/r75/three.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/175711/bas.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/175711/TextGeometry.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/175711/FontUtils.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/175711/pnltri.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/175711/droid_sans_bold.typeface.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js'></script>
<script src='assets/js/logout.js'></script>
<link rel='stylesheet' href='assets/css/logout.css'/>
<title>Logging Out...</title>

<div id='three-container'></div>

";

session_destroy();
//header('Location: index.php');
return;
?>