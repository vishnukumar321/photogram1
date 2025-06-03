<?php
include_once "lib/load.php";
session::isautherize();
get_template("head");
get_template("main");
get_template("footer");
?>