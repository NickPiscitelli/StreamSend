<?php

session_start();

// Logout
unset($_SESSION['name']);
unset($_SESSION['logged_in']);
header('Location: login.php');