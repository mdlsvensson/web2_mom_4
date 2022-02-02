<?php

  // Title
  $site_title = "Blog";
  $divider = " - ";

  // Aktiverra felrapportering
  error_reporting(-1);
  ini_set("display_errors", 1);

  spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
  });

  if (!isset($_SESSION)) {
    session_start();
  }