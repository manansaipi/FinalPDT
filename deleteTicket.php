<?php
session_start();
if (!isset($_SESSION['login'])) {
	header('location: login.php');
	exit();
}
require 'functions.php';

$id = $_GET['id'];

if (deleteTicket($id) > 0) {
	echo "  <script>
                alert('Ticket deleted !')
                document.location.href = 'tableTicket.php'
            </script>";
} else {
	echo "<script>alert('erorr!') document.location.href = 'index.php'</script>";
}
