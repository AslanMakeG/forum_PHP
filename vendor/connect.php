<?php

$connect = mysqli_connect('localhost', 'root', '', 'forum');

if (!$connect){
    die('Error connect to Database');
}