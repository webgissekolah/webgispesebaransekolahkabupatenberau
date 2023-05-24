<!DOCTYPE html>

    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AdminLTE 3 | Top Navigation</title>

<!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?=base_url()?>assets/template/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url()?>assets/template/dist/css/adminlte.min.css">

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="<?=base_url()?>assets/template/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?=base_url()?>assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?=base_url()?>assets/template/dist/js/adminlte.min.js"></script>
        <!--AdminLTE for demo purposes-->
        <script src="<?=base_url()?>assets/template/dist/js/demo.js"></script>

        <body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
    <div class="container">
      <a href="?=base_url()?>assets/template/index3.html" class="navbar-brand">
      <img src="<?=base_url()?>/assets/logo.png" alt="AdminLTE Logo" class="brand-image imgsquare elevation-3" style="opacity: .8">
        <span style="color:gold" class="brand-text font-weight-light">WEBGIS PESEBARAN SEKOLAH KABUPATEN BERAU</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <link rel="stylesheet" href="<?=base_url()?>assets/leaflet.groupedlayercontrol.css" />
        <script src="<?=base_url()?>assets/leaflet.groupedlayercontrol.js"></script>

        <link rel="stylesheet" href="<?=base_url()?>assets/Control.MiniMap.css" />
        <script src="<?=base_url()?>assets/Control.MiniMap.js"></script>

        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css">
        <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/L.Control.ZoomBar.css"/>
        <script type="text/javascript" src="<?=base_url()?>assets/L.Control.ZoomBar.js"></script>

        <script type="text/javascript" src="<?=base_url()?>assets/Leaflet.Coordinates-0.1.5.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/Leaflet.Coordinates-0.1.5.css"/>
    </head>
