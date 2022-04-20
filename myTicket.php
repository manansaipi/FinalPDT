<?php  
session_start();
if (!isset($_SESSION["login"])){
  header("location: login.php");
  exit;
}
require 'functions.php';
$image = $_SESSION['image'];
$seasonId = $_SESSION['id'];
$position = $_SESSION['position'];
$name = $_SESSION['name'];
$data = query("SELECT * FROM ticket WHERE creator = '$name'");
$id = query("SELECT * FROM users where id = $seasonId");


if(isset($_POST["submit"])){
    if(addTicket($_POST) > 0 ){
        echo "<script>alert('Ticket added !');document.location.href = 'myTicket.php';</script>";
    } else {
        echo "<script>alert('erorr!'); document.location.href = 'index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Color Utilities</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span>
                </a>
                
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Table :</h6>                
                        <a class="collapse-item" href="tableEmployee.php">Employee</a>
                        <a class="collapse-item" href="tableTicket.php">Ticket</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href='myTicket.php'"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>My Ticket</span>
                </a>

            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            

            <!-- Nav Item - Pages Collapse Menu -->
            

            <!-- Nav Item - Charts -->
            <?php foreach ($id as $id) : ?>
                <li class="nav-item">
            
            <a class="nav-link" href='profileUpdate.php?id=<?= $id["id"]; ?>'>
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                <span>Profile</span></a>
               
        
            </li>  

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <form class="form" action="" method="post" enctype="multipart/form-data">
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        <!-- Nav Item - Alerts -->
                       

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/<?= $_SESSION['image']; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profileUpdate.php?id<?= $id["id"] ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">My Ticket</h1>

                    <!-- DataTales Example -->
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                            <div class="col-12 col-md-3 mb-3">     
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Ticket</th>
                                            <th>Problem</th>
                                            <th>Date Created</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>No Ticket</th>
                                            <th>Problem</th>
                                            <th>Date Created</th>
                                            <th>Status</th>
                                            <th  style="text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php global $number; ?>
                                        <?php foreach( $data as $data ) : ?>
                                        <tr >
                                            <td><?= $number += 1; ?></td>
                                            <td><?= $data["id"]?></td>
                                            <td><?= $data["ticket_title"]?></td>
                                            <td><?= $data["date_ticket"]?></td>
                                            <?php if($data['status_ticket'] == 0) : ?>
                                            <td><span class="badge badge-warning m-0">Waiting</span></td>
                                            <?php elseif($data['status_ticket'] == 1) : ?>
                                            <td><span class="badge badge-info m-0">In Progres</span></td>
                                            <?php elseif($data['status_ticket'] == 2) : ?>
                                            <td><span class="badge badge-success m-0">Success</span></td>
                                            <?php else : ?>
                                            <td><span class="badge badge-danger m-0">Canceled</span></td>
                                            <?php endif; ?>
                                            <td style="text-align: center;">
                                            
                                            <?php if($data['status_ticket'] != 2) : ?>
                                            <a href="detailMyTicket.php?id=<?php echo $data['id']; ?>" class="btn btn-info btn-icon-split btn-sm">
                                            <span class="text">Detail</span>
                                            </a> 
                                            <?php else : ?>
                                            <a href="detailMyTicket.php?id=<?php echo $data['id']; ?>" class="btn btn-success btn-icon-split btn-sm">
                                            <span class="text">See Feedback</span>
                                            </a> 
                                            <?php endif; ?> 
                                            

                                        </td>
                                        </tr>
                                        
                                        <?php endforeach;?>
                                        
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTicket">Add Ticket</button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
                </div>
                <!-- /.container-fluid -->
                </div></div>
                </div>
                                            
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; BenTeng 2022</span>
                    </div>
                </div>
                
            </footer>
            <!-- End of Footer -->
            </div>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report Problem</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="col">
                            <div class="row">
                                <div class="form-group">
                                <label><b>Complaint</b></label>    
                                <input class="form-control" type="text" name="ticket_title" />       
                                <input style="display: none;" type="date" value="<?php echo date('Y-m-d'); ?>" name="date_ticket">  
                                <input type="hidden" name="creator" value="<?php echo $id['name']; ?>">     
                                <input type="hidden" name="status_ticket" value="0">
                                <input type="hidden" name="id_user" value="<?php echo $id['id'] ?>" />
                                <input type="hidden" name="solved_by" valu=" ">
                                <input type="hidden" name="feedback" valu=" ">
                           </div> 
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label><b>Description</b></label>
                              <textarea class="form-control" rows="3" name="desc_ticket"></textarea>
                            </div>
                          </div>
                        </div>
                        <input class="" type="file" name="image"/>

                    </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="submit" name="submit" >Add</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <?php endforeach; ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>