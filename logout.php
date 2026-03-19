<?php

session_start();
unset($_SESSION["user"]);
unset($_SESSION["client"]);
header("Location: index.php");
