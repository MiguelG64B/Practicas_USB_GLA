<?php
session_start();
include "./php/conexion.php";
if (!isset($_SESSION['datos_login'])) {
  header("Location: ./index.php");
}
$arregloUsuario = $_SESSION['datos_login'];
$idestado = $arregloUsuario['id_estado'];
if ($idestado != 5) {
  header("Location: ./inactivo.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>
    Usuario inactivo
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Agrega jQuery a tu página -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class=""><div id="ofBar" style="display:none"><div id="ofBar-logo"> <img alt="creative-tim-logo" src="https://s3.amazonaws.com/creativetim_bucket/static-assets/logo-ct-black.png"></div><div id="ofBar-content">🍁🍁 Elevate Your Web Dev Game with <b>Creative Tim’s Special Bundles - 85% OFF</b>!</div><div id="ofBar-right"><a href="https://www.creative-tim.com/campaign?ref=ct-demos" target="_blank" id="btn-bar">Get Offer</a><a id="close-bar">×</a></div></div>





<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
<div class="container">

<button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon mt-2">
<span class="navbar-toggler-bar bar1"></span>
<span class="navbar-toggler-bar bar2"></span>
<span class="navbar-toggler-bar bar3"></span>
</span>
</button>
<div class="collapse navbar-collapse" id="navigation">
<ul class="navbar-nav mx-auto">
<li class="nav-item">

</li>
<li class="nav-item">

</li>
<li class="nav-item">

</li>
<li class="nav-item">

</li>
</ul>
<ul class="navbar-nav d-lg-block d-none">
<li class="nav-item">
<a href="https://www.creative-tim.com/product/argon-dashboard" class="btn btn-sm mb-0 me-1 bg-gradient-light">Salir</a>
</li>
</ul>
</div>
</div>
</nav>

<main class="main-content mt-0 ps ps--active-y">
<div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
<span class="mask bg-gradient-dark opacity-6"></span>
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-5 text-center mx-auto">
<h1 class="text-white mb-2 mt-5">Welcome!</h1>
<p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
<div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
<div class="card z-index-0">



</div>
</div>
</div>
</div>
<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px; height: 318px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 204px;"></div></div></main>

<footer class="footer py-5">
<div class="container">
<div class="row">

<div class="col-lg-8 mx-auto text-center mb-4 mt-2">
<a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
<span class="text-lg fab fa-dribbble" aria-hidden="true"></span>
</a>
<a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
<span class="text-lg fab fa-twitter" aria-hidden="true"></span>
</a>
<a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
<span class="text-lg fab fa-instagram" aria-hidden="true"></span>
</a>
<a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
<span class="text-lg fab fa-pinterest" aria-hidden="true"></span>
</a>
<a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
<span class="text-lg fab fa-github" aria-hidden="true"></span>
</a>
</div>
</div>
<div class="row">
<div class="col-8 mx-auto text-center mt-1">
<p class="mb-0 text-secondary">
Copyright © <script>
              document.write(new Date().getFullYear())
            </script>2023 Soft by Creative Tim.
</p>
</div>
</div>
</div>
</footer>


<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

<script async="" defer="" src="https://buttons.github.io/buttons.js"></script>

<script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
<script defer="" src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon="{&quot;rayId&quot;:&quot;828e486e5dc8f78e&quot;,&quot;version&quot;:&quot;2023.10.0&quot;,&quot;token&quot;:&quot;1b7cbb72744b40c580f8633c6b62637e&quot;}" crossorigin="anonymous"></script>


<style>
  #ofBar {
    background: #fff;
    z-index: 999999999;
    font-size: 16px;
    color: #333;
    padding: 16px 40px;
    font-weight: 400;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 40px;
    width: 80%;
    border-radius: 8px;
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 13px 27px -5px rgba(50,50,93,0.25), 0 8px 16px -8px rgba(0,0,0,0.3), 0 -6px 16px -6px rgba(0,0,0,0.025);
  }

  #ofBar-logo img {
    height: 50px;
  }

  #ofBar-content {
    display: inline;
    padding: 0 15px;
  }

  #ofBar-right {
    display: flex;
    align-items: center;
  }

  #ofBar b {
    font-size: 15px !important;
  }
  #count-down {
    display: initial;
    padding-left: 10px;
    font-weight: bold;
    font-size: 20px;
  }
  #close-bar {
    font-size: 17px;
    opacity: 0.5;
    cursor: pointer;
    color: #808080;
    font-weight: bold;
  }
  #close-bar:hover{
    opacity: 1;
  }
  #btn-bar {
    background-image: linear-gradient(310deg, #141727 0%, #3A416F 100%);
    color: #fff;
    border-radius: 4px;
    padding: 10px 20px;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
    font-size: 12px;
    opacity: .95;
    margin-right: 20px;
    box-shadow: 0 5px 10px -3px rgba(0,0,0,.23), 0 6px 10px -5px rgba(0,0,0,.25);
  }
   #btn-bar, #btn-bar:hover, #btn-bar:focus, #btn-bar:active {
     text-decoration: none !important;
     color: #fff !important;
 }
  #btn-bar:hover{
    opacity: 1;
  }

  #btn-bar span, #ofBar-content span {
    color: red;
    font-weight: 700;
  }

  #oldPriceBar {
    text-decoration: line-through;
    font-size: 16px;
    color: #fff;
    font-weight: 400;
    top: 2px;
    position: relative;
  }
  #newPrice{
    color: #fff;
    font-size: 19px;
    font-weight: 700;
    top: 2px;
    position: relative;
    margin-left: 7px;
  }

  #fromText {
    font-size: 15px;
    color: #fff;
    font-weight: 400;
    margin-right: 3px;
    top: 0px;
    position: relative;
  }
  
  #pls-contact-me-on-email {
    position: absolute;
    color: white;
    width: 100%;
    height: 100%;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.9);
    z-index: 999;
    cursor: pointer;
    padding-top: 100px;
    padding-left: 50px;
  }

  @media(max-width: 991px){

  }
  @media (max-width: 768px) {
    #count-down {
      display: block;
      margin-top: 15px;
    }

    #ofBar {
      flex-direction: column;
      align-items: normal;
    }

    #ofBar-content {
      margin: 15px 0;
      text-align: center;
      font-size: 18px;
    }

    #ofBar-right {
      justify-content: flex-end;
    }
  }
</style>

<script type="text/javascript" id="">function setCookie(a,d,c){var b=new Date;b.setTime(b.getTime()+864E5*c);c="expires\x3d"+b.toUTCString();document.cookie=a+"\x3d"+d+";"+c+";path\x3d/"}
function readDomain(){domain=window.location.hostname;if("hrm.newflex.co.kr"==domain){console.log("Remove the script");var a=document.createElement("div");a.setAttribute("id","pls-contact-me-on-email");a.innerHTML="\x3ch1\x3ePlease Remove the Stolen Google Analytics from \x3ca href\x3d'https://www.creative-tim.com/?ref\x3dstolen-website' target\x3d'_blank' '\x3ecreative-tim.com\x3c/a\x3e Please send an email to beni@creative-tim.com to help you remove our scripts.\x3c/h1\x3e";document.body.insertBefore(a,
document.body.firstChild)}}function readCookie(a){a+="\x3d";for(var d=document.cookie.split(";"),c=0;c<d.length;c++){for(var b=d[c];" "==b.charAt(0);)b=b.substring(1,b.length);if(0==b.indexOf(a))return b.substring(a.length,b.length)}return null}
function createOfferBar(){readDomain();var a=document.createElement("div");a.setAttribute("id","ofBar");a.innerHTML="\x3cdiv id\x3d'ofBar-logo'\x3e \x3cimg alt\x3d'creative-tim-logo' src\x3d'https://s3.amazonaws.com/creativetim_bucket/static-assets/logo-ct-black.png'\x3e\x3c/div\x3e\x3cdiv id\x3d'ofBar-content'\x3e\ud83c\udf41\ud83c\udf41 Elevate Your Web Dev Game with \x3cb\x3eCreative Tim\u2019s Special Bundles - 85% OFF\x3c/b\x3e!\x3c/div\x3e\x3cdiv id\x3d'ofBar-right'\x3e\x3ca href\x3d'https://www.creative-tim.com/campaign?ref\x3dct-demos' target\x3d'_blank' id\x3d'btn-bar'\x3eGet Offer\x3c/a\x3e\x3ca id\x3d'close-bar'\x3e\u00d7\x3c/a\x3e\x3c/div\x3e";document.body.insertBefore(a,
document.body.firstChild)}function closeOfferBar(){document.getElementById("ofBar").setAttribute("style","display:none");setCookie("view_offer_bar","true",1)}var value=readCookie("view_offer_bar");null==value&&(createOfferBar(),document.getElementById("close-bar").addEventListener("click",closeOfferBar));</script>
	<script type="text/javascript" id="">!function(d,g,e){d.TiktokAnalyticsObject=e;var a=d[e]=d[e]||[];a.methods="page track identify instances debug on off once ready alias group enableCookie disableCookie".split(" ");a.setAndDefer=function(b,c){b[c]=function(){b.push([c].concat(Array.prototype.slice.call(arguments,0)))}};for(d=0;d<a.methods.length;d++)a.setAndDefer(a,a.methods[d]);a.instance=function(b){b=a._i[b]||[];for(var c=0;c<a.methods.length;c++)a.setAndDefer(b,a.methods[c]);return b};a.load=function(b,c){var f="https://analytics.tiktok.com/i18n/pixel/events.js";
a._i=a._i||{};a._i[b]=[];a._i[b]._u=f;a._t=a._t||{};a._t[b]=+new Date;a._o=a._o||{};a._o[b]=c||{};c=document.createElement("script");c.type="text/javascript";c.async=!0;c.src=f+"?sdkid\x3d"+b+"\x26lib\x3d"+e;b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(c,b)};a.load("CC6UAQBC77U7GVKHLC4G");a.page()}(window,document,"ttq");</script>
	<iframe id="_hjSafeContext_77943506" title="_hjSafeContext" tabindex="-1" aria-hidden="true" src="about:blank" style="display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;"></iframe></body>

</html>