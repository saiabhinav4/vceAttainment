<?php
    require "pages/common/connection.php";
    $fid="";
    if(isset($_SESSION['department']) and !empty($_SESSION['department'])){
        $branch=$_SESSION['department'];
        // print_r($branch); exit();
        $fid=$_SESSION['fid'];
    }
    else{
        header('location:index.php');
    }

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <style>
      .branch-heading{
        color:#000;
      }
      .loading{
        position: relative;
            left: 80px;
            top: 0px;
            width: 100% !important;
            height: 4rem;
            background: url('images/Rolling.gif') 10% 10% no-repeat;
      }
      .custom-batch{
        font-size: 15px;
        margin-bottom: 0.8rem;
      }
      .custom-value{
        font-weight: 400;
        color:#333;
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div
          class="navbar-menu-wrapper d-flex align-items-center justify-content-end"
        >
          <button
            class="navbar-toggler navbar-toggler align-self-center"
            type="button"
            data-toggle="minimize"
          >
            <span class="ti-view-list"></span>
          </button>
          <ul class="navbar-nav mr-lg-2 flex-grow-1">
            <li class="nav-item nav-search d-lg-block">
              <h4 class="branch-heading">PRINCIPAL</h4>
            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
          
            <li class="nav-item dropdown">
              <a
                class="nav-link count-indicator dropdown-toggle"
                id="notificationDropdown"
                href="#"
                data-bs-toggle="dropdown"
              >
                <i class="ti-bell mx-0"></i>
                <span class="count"></span>
              </a>
              <div
                class="dropdown-menu dropdown-menu-right navbar-dropdown"
                aria-labelledby="notificationDropdown"
              >
                <p class="mb-0 font-weight-normal float-left dropdown-header">
                  Notifications
                </p>
                <a class="dropdown-item">
                  <div class="item-thumbnail">
                    <div class="item-icon bg-success">
                      <i class="ti-info-alt mx-0"></i>
                    </div>
                  </div>
                  <div class="item-content">
                    <h6 class="font-weight-normal">Application Error</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Just now
                    </p>
                  </div>
                </a>
                <a class="dropdown-item">
                  <div class="item-thumbnail">
                    <div class="item-icon bg-warning">
                      <i class="ti-settings mx-0"></i>
                    </div>
                  </div>
                  <div class="item-content">
                    <h6 class="font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Private message
                    </p>
                  </div>
                </a>
                <a class="dropdown-item">
                  <div class="item-thumbnail">
                    <div class="item-icon bg-info">
                      <i class="ti-user mx-0"></i>
                    </div>
                  </div>
                  <div class="item-content">
                    <h6 class="font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                data-bs-toggle="dropdown"
                id="profileDropdown"
              >
                <img src="images/faces/admin.jpg" alt="profile" />
              </a>
              <div
                class="dropdown-menu dropdown-menu-right navbar-dropdown"
                aria-labelledby="profileDropdown"
              >
                <a class="dropdown-item" href="logout.php" >
                  <i class="ti-power-off text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
          <button
            class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
            type="button"
            data-toggle="offcanvas"
          >
            <span class="ti-view-list"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item active">
              <a class="nav-link" href="">
                <i class="ti-shield menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="collapse"
                href="#ui-attainment"
                aria-expanded="false"
                aria-controls="ui-attainment"
              >
                <i class="ti-palette menu-icon"></i>
                <span class="menu-title">Attainments</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-attainment">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/GlobalCoattainment.php"
                      >CO Attainments</a
                    >
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/poattainment.php"
                      >PO Attainments</a
                    >
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="collapse"
                href="#manage-course"
                aria-expanded="false"
                aria-controls="manage-course"
              >
                <i class="ti-book menu-icon"></i>
                <span class="menu-title"> Manage HODs</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="manage-course">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/manageHods.php">
                          Modify Hod Account
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item" id="Mweights">
              <a class="nav-link" href="pages/ui-features/weightage.php">
                <i class="ti-layout-list-post menu-icon"></i>
                <span class="menu-title">Modify Weightages</span>
              </a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="" style="cursor:pointer;"  data-bs-toggle="modal" data-bs-target="#exampleModal1" 
                      >
                      <i class="ti-exchange-vertical menu-icon"></i>
                <span class="menu-title">Change Password</span>
                      </a
                    >
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/regulation.php">
                    <i class="ti-info-alt menu-icon"></i>
                <span class="menu-title">Regulation</span>
                    </a>
                  </li>
            <!-- <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="collapse"
                href="#manage-faculty"
                aria-expanded="false"
                aria-controls="manage-faculty"
              >
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">Manage Faculty</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="manage-faculty">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/facultydetails.php">
                      Faculty Details
                    </a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      href="pages/ui-features/mappingfandc.php"
                    >
                      Faculty-Course Mapping
                    </a>
                  </li>
                  
                </ul>
              </div>
            </li> -->
            <!-- <li class="nav-item">
              <a
                class="nav-link"
                data-bs-toggle="collapse"
                href="#others"
                aria-expanded="false"
                aria-controls="others"
              >
                <i class="ti-map menu-icon"></i>
                <span class="menu-title">other</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="others">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pages/ui-features/regulation.php">
                      Regulation
                    </a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      href=""
                      id="modal-click"
                      data-bs-toggle="modal" 
                      data-bs-target="#exampleModal"
                    >
                    threshold Value
                    </a>
                  </li>
                  
                </ul>
              </div>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/weightage.php">
                <i class="ti-layout-list-post menu-icon"></i>
                <span class="menu-title">Modify Weightages</span>
              </a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/indirectpos.php">
                <i class="ti-pie-chart menu-icon"></i>
                <span class="menu-title">PO Indirect Assessment</span>
              </a>
            </li> -->
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h4 class="font-weight-bold mb-0">Dashboard</h4>
                  </div>
                      <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Select the Department</label
                                  >
                                  <select
                                    name="department"
                                    id="branch"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT DEPARTMENT--</option>
                                    <!-- <option value="IT">IT</option>
                                    <option value="CSE">CSE</option>
                                    <option value="ECE">ECE</option>
                                    <option value="EEE">EEE</option>
                                    <option value="MECH">MECH</option>
                                    <option value="CIVIL">CIVIL</option> -->
                                  </select>
                        </div>
                  <div>
                    <button
                      type="button"
                      class="btn btn-primary btn-icon-text btn-rounded"
                      id="reload"
                    >
                      <i class="ti-reload btn-icon-prepend"></i>Refresh
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Total Course Outcomes (CO's)</p>
                    <div
                      class=" d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                     <!-- <div class=" "> -->
                      <h3 class="loading mb-0  mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="Tco">
                        
                      </h3>
                      <!-- </div> -->
                      <!-- <i
                        class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-danger">
                      0.12%
                      <span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Total Attained Course Outcomes (CO's)
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="Aco">
                        
                      </h3>
                      <!-- <i
                        class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-danger">
                      0.47%
                      <span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Total Non-Attained Course Outcomes (CO's)
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="NAco">
                        
                      </h3>
                      <!-- <i
                        class="ti-agenda icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-success">
                      64.00%<span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Returns
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center"
                    >
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">
                        61344
                      </h3>
                      <i
                        class="ti-layers-alt icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i>
                    </div>
                    <p class="mb-0 mt-2 text-success">
                      23.00%<span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p>
                  </div>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Total Program Outcomes (PO's)</p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0  mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="TPO">
                        
                      </h3>
                      <!-- <i
                        class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-danger">
                      0.12%
                      <span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Total Attained Program Outcomes (PO's)
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="APO">
                        
                      </h3>
                      <!-- <i
                        class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-danger">
                      0.47%
                      <span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Total Non-Attained Program Outcomes (PO's)
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="NAPO">
                        
                      </h3>
                      <!-- <i
                        class="ti-agenda icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-success">
                      64.00%<span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Returns
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center"
                    >
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">
                        61344
                      </h3>
                      <i
                        class="ti-layers-alt icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i>
                    </div>
                    <p class="mb-0 mt-2 text-success">
                      23.00%<span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p>
                  </div>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Total Program Specific Outcomes (PSO's)</p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0  mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="TPSO">
                        
                      </h3>
                      <!-- <i
                        class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-danger">
                      0.12%
                      <span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Total Attained Program Specific Outcomes (PSO's)
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="APSO">
                        
                      </h3>
                      <!-- <i
                        class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-danger">
                      0.47%
                      <span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Total Non-Attained Program Specific Outcomes (PSO's)
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-center justify-content-md-center justify-content-xl-center align-items-center"
                    >
                      <h3 class="loading mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0" id="NAPSO">
                        
                      </h3>
                      <!-- <i
                        class="ti-agenda icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i> -->
                    </div>
                    <!-- <p class="mb-0 mt-2 text-success">
                      64.00%<span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">
                      Returns
                    </p>
                    <div
                      class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center"
                    >
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">
                        61344
                      </h3>
                      <i
                        class="ti-layers-alt icon-md text-muted mb-0 mb-md-3 mb-xl-0"
                      ></i>
                    </div>
                    <p class="mb-0 mt-2 text-success">
                      23.00%<span class="text-black ms-1"
                        ><small>(30 days)</small></span
                      >
                    </p>
                  </div>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title">Batch-Wise CO Bar Graph </p>
                    <!-- <p class="text-muted font-weight-light">
                      Received overcame oh sensible so at an. Formed do change
                      merely to county it. Am separate contempt domestic to to
                      oh. On relation my so addition branched.
                    </p> -->
                    <div
                      id="sales-legend"
                      class="chartjs-legend mt-4 mb-2"
                    ></div>
                    <div id="changeCOG" class="loading">
                    <canvas id="sales-chart"></canvas>
                    </div>
                    <div class="d-flex justify-content-between " style="margin: 0 1rem;">
                      <i class="ti-angle-left" id="left" style="cursor:pointer;"></i>
                      <i class="ti-angle-right" id="right" style="cursor:pointer;"></i>
                    </div>
                     
                  </div>

                 
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title">Batch-Wise Overall PO's  & PSO's Bar Graph </p>
                    <!-- <p class="text-muted font-weight-light">
                      Received overcame oh sensible so at an. Formed do change
                      merely to county it. Am separate contempt domestic to to
                      oh. On relation my so addition branched.
                    </p> -->
                    <div
                      id="PO-legend"
                      class="chartjs-legend mt-4 mb-2"
                    ></div>
                    <div id="changePOG" class="loading">
                      <canvas id="Pos-chart"></canvas>
                    </div>
                    <div class="d-flex justify-content-between " style="margin: 0 1rem;">
                      <i class="ti-angle-left" id="Pleft" style="cursor:pointer;"></i>
                      <i class="ti-angle-right" id="Pright" style="cursor:pointer;"></i>
                    </div>
                     
                  </div>

                 
                </div>
              </div>
            </div>
            <!-- cut -->
            
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div
              class="d-sm-flex justify-content-center justify-content-sm-between"
            >
              <span
                class="text-muted text-center text-sm-left d-block d-sm-inline-block"
                >Copyright ©
                <a href="https://vardhaman.org/" target="_blank"
                  >Vardhaman College Of Engineering  </a
                >2022</span
              >
              <span
                class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"
                >Developed By Department of Information Technology
                <!-- <a href="https://www.bootstrapdash.com/" target="_blank">
                  Bootstrap dashboard
                </a> -->
                </span
              >
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->


      
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="exampleModalLabel" >Threshold Value</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  
      <div class="modal-body">
          <p>Modify the threshold Value, Which is the Percentage of Maximum Marks.</p>
          <form >
            <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Enter Threshold %</label
                                >
                                <input
                                  type="number"
                                  name="thValue"
                                  id="tvalue"
                                  class="form-control"
                                  placeholder="ex:60"
                                  title="Enter Threshold Value"
                                />
                              </div>
                            </div>
                            <div class="col-md-2">
                                <h4>&nbsp;</h4>
                              <a class="btn btn-xs btn-success" id="modify-tvalue">submit</a>
                            </div>
            </div>
            <div class="row">
              <div id="result1" class="col-md-12">

              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

              
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="exampleModalLabel" >Change Password</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  
      <div class="modal-body">
          <!-- <p>Modify the threshold Value,  Which is the Percentage of Maximum Marks.</p> -->
          <form >
            <div class="row">          
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Enter Previous Password</label
                                >
                                <input
                                  type="password"
                                  name="thValue"
                                  id="prePass"
                                  class="form-control"
                                  placeholder="Enter Here"
                                  title="Enter Previous Password"
                                />
                              </div>
                            </div>
                           
            </div>
            <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Enter New Password</label
                                >
                                <input
                                  type="password"
                                  name="new-Value"
                                  id="newPass"
                                  class="form-control"
                                  placeholder="Enter Here"
                                  title="Enter New Password"
                                />
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Re-Enter New Password</label
                                >
                                <input
                                  type="password"
                                  name="rnew-Value"
                                  id="RnewPass"
                                  class="form-control"
                                  placeholder="Enter Here"
                                  title="Re-Enter New Password"
                                />
                              </div>
                            </div>
            </div>
            <div class="row">
                            <div class="col-md-2">
                            
                              <a class="btn btn-xs btn-success" id="submit-pass">submit</a>
                            </div>        
            </div>
            <div class="row">
              <div id="result4" class="col-md-12">

              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

    <!-- plugins:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->


    <script>

let fid=`<?php echo $fid; ?>`;
          $('#submit-pass').click(function(){
              let prevPas=document.getElementById('prePass');
              let newPass=document.getElementById('newPass');
              let renewPass=document.getElementById('RnewPass');
              if(prevPas.value!='' && newPass.value!="" && renewPass.value!=''){
                $.ajax({
                      url:'pages/scripts/regulationScript.php',
                      type:'post',
                      data:{type:7,previousPass:prevPas.value,newPass:newPass.value,renewPass:renewPass.value,fid:fid},
                      beforeSend: function(){
                            $('#result4').empty();
                        },
                        success: function(response){
                          $('#result4').empty();
                            $('#result4').html(response);
                        },
                        complete:function(data){     
                          
                        } 
                        }); 

              }else{
                alert('Enter all Fields in Password Modal');
              }

          });


        let branch=`<?php echo $branch; ?>`;

         
        
        let value=document.getElementById('tvalue')
        function get_Tvalue(){
          $.ajax({
                      url:'pages/scripts/regulationScript.php',
                      type:'post',
                      data:{type:5,branch:branch},
                      beforeSend: function(){
                        },
                        success: function(response){
                         if("msg" in response){
                              //  $('#tvalue').attr('value',);
                               value.value=response['msg']; 
                         } 
                         else{
                              $('#result1').html(response)
                              
                         }
                        },
                        complete:function(data){
                        } 
                  });
        }

      $('#modal-click').click(get_Tvalue);
       
      $('#modify-tvalue').click(function(){
        $.ajax({
                      url:'pages/scripts/regulationScript.php',
                      type:'post',
                      data:{type:6,branch:branch,tvalue:value.value},
                      beforeSend: function(){
                        },
                        success: function(response){
                              $('#result1').html(response)
                        },
                        complete:function(data){
                          get_Tvalue();
                        } 
                  });
      });





     


    </script>














    <!-- Plugin js for this page-->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <!-- End custom js for this page-->
    <script>
          let TotalCo=document.getElementById('Tco');
          let AttainedCo=document.getElementById('Aco');
          let NonAttainedCo=document.getElementById('NAco');
          let TotalPO=document.getElementById('TPO');
          let AttainedPo=document.getElementById('APO');
          let NonAttainedPo=document.getElementById('NAPO');
          let TotalPso=document.getElementById('TPSO');
          let AttainedPso=document.getElementById('APSO');
          let NonAttainedPso=document.getElementById('NAPSO');
          let COGraph=document.getElementById('changeCOG');
          let POGraph=document.getElementById('changePOG');
          let selectDept=document.getElementById('branch');
          let Lables=null;
          let Total=[];
          let Attained=[];
          let POArray=[];
          let department=[];
          let departmentArray;
          let currentDept=[];
          let max=9;
          let left_i=0;
          let right_i=0;
          let Pindex=0;
          let left=document.getElementById('left');
          let right=document.getElementById('right');
          let Pleft=document.getElementById('Pleft');
          let Pright=document.getElementById('Pright');
        function get_DashBoard(){
          $.ajax({
                      url:'pages/scripts/dashboardScript.php',
                      type:'post',
                      data:{branch:branch},
                      beforeSend: function(){
                            TotalCo.innerHTML="";
                            TotalCo.classList.add('loading');
                            AttainedCo.innerHTML="";
                            AttainedCo.classList.add('loading');
                            NonAttainedCo.innerHTML="";
                            NonAttainedCo.classList.add('loading');
                            TotalPO.innerHTML="";
                            TotalPO.classList.add('loading');
                            AttainedPo.innerHTML="";
                            AttainedPo.classList.add('loading');
                            NonAttainedPo.innerHTML="";
                            NonAttainedPo.classList.add('loading');
                            TotalPso.innerHTML="";
                            TotalPso.classList.add('loading');
                            AttainedPso.innerHTML="";
                            AttainedPso.classList.add('loading');
                            NonAttainedPso.innerHTML="";
                            NonAttainedPso.classList.add('loading');
                            $("#sales-chart").remove(); // this is my <canvas> element
                            $("#changeCOG").append('<canvas id="sales-chart"><canvas>');
                            // canvas = document.querySelector("#sales-chart");
                            COGraph.classList.add('loading');
                            $("#Pos-chart").remove(); // this is my <canvas> element
                            $('#PO-legend').empty();
                            $("#changePOG").append('<canvas id="Pos-chart"><canvas>');
                            // canvas = document.querySelector("#Pos-chart");
                            POGraph.classList.add('loading');
                        },
                        success: function(response){
                          console.log(response);
                          Total=[];
                          Attained=[];
                          POArray=[];
                          right.style.pointerEvents="auto";
            right.style.cursor="pointer";
            right.style.color="#000";
            left.style.pointerEvents="auto";
            left.style.cursor="pointer";
            left.style.color="#000";
            Pleft.style.pointerEvents="auto";
            Pleft.style.cursor="pointer";
            Pleft.style.color="#000";
            Pright.style.pointerEvents="auto";
            Pright.style.cursor="pointer";
            Pright.style.color="#000";
                            TotalCo.classList.remove('loading');
                            AttainedCo.classList.remove('loading');
                            NonAttainedCo.classList.remove('loading');
                            TotalPO.classList.remove('loading');
                            AttainedPo.classList.remove('loading');
                            NonAttainedPo.classList.remove('loading');
                            TotalPso.classList.remove('loading');
                            AttainedPso.classList.remove('loading');
                            NonAttainedPso.classList.remove('loading');
                            COGraph.classList.remove('loading');
                            POGraph.classList.remove('loading');
                          // console.log(Object.keys(response.Batchwise));
                          
                         if("error" in response){
                              //  $('#tvalue').attr('value',);
                              //  value.value=response['msg']; 
                         } 
                         else{

                              departmentArray=Object.keys(response);
                              console.log(departmentArray);
                              // department=new Array(departmentArray.length);
                              let i=0;
                              for(const dept of Object.entries(response)){
                                    console.log(departmentArray[i],dept);
                                    Lables=Object.keys(dept[1].Batchwise);
                                    let j=0;
                                    let deptAll=[];
                                    for(const batch of Object.entries(dept[1].Batchwise)){
                                          let batchsArray=[];
                                             console.log(batch[1].Total);
                                             batchsArray.push(batch[1].Total);
                                             batchsArray.push(batch[1].Attained);
                                             batchsArray.push(batch[1].TotalPO);
                                             batchsArray.push(batch[1].AttainedPO);
                                             batchsArray.push(batch[1].TotalPSO);
                                             batchsArray.push(batch[1].AttainedPSO);
                                         
                                             if(batch[1].Total>max){
                                                max=batch[1].Total;
                                              }
                                              // Total.push(batch[1].Total);
                                              // Attained.push(batch[1].Attained);
                                          if(typeof batch[1].OverallPO==='string'){
                                            batchsArray.push([0,0,0,0,0,0,0,0,0,0,0,0,0,0]);
                                          }else if( Array.isArray(batch[1].OverallPO) && batch[1].OverallPO.length==0)
                                          {
                                            batchsArray.push([0,0,0,0,0,0,0,0,0,0,0,0,0,0]);
                                          }else {
                                            batchsArray.push(Object.keys(batch[1].OverallPO).map(function(key){
                                                return batch[1].OverallPO[key];
                                          }));
                                        }
                             
                                                console.log(batchsArray,i,j);
                                                deptAll.push(batchsArray);
                                               
                                        j++;                       
                                    }
                                    i++;
                                    department.push(deptAll);
                              
                              }
                              console.log(Lables);
                              console.log(department);

                              selectDept.innerHTML=``;
                              let optionsStr=``;
                              for(let k=0;k<departmentArray.length;k++){
                                  optionsStr+=`
                                    <option value="${departmentArray[k]}">${departmentArray[k]}</option>
                                  `;
                              }
                              selectDept.innerHTML=optionsStr;
                          
                          currentDept=department[0];
                          for(let l=0;l<currentDept.length;l++){
                            Total.push(currentDept[l][0]);
                          }
                          for(let l=0;l<currentDept.length;l++){
                            Attained.push(currentDept[l][1]);
                          }
                          for(let l=0;l<currentDept.length;l++){
                            POArray.push(currentDept[l][6]);
                          }
                          max+=5;
                          console.log(max,currentDept);
                             
                            TotalCo.innerHTML=``;
                              let str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][0]}</span></div>`;
                                }

                                str+=`</div>`;
                              TotalCo.innerHTML=str; 

                              AttainedCo.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][1]}</span></div>`;
                                }

                                str+=`</div>`;
                                AttainedCo.innerHTML=str;
                              
                              
                              
                              NonAttainedCo.innerHTML=``;
                               str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][0]-currentDept[i][1]}</span></div>`;
                                }
                                str+=`</div>`;
                              NonAttainedCo.innerHTML=str;
                              

                              TotalPO.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][2]}</span></div>`;
                                }
                                 str+=`</div>`;
                                TotalPO.innerHTML=str;
                              
                              AttainedPo.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][3]}</span></div>`;
                                }
                                 str+=`</div>`;
                                AttainedPo.innerHTML=str;

                              

                              NonAttainedPo.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][2]-currentDept[i][3]}</span></div>`;
                                }
                                 str+=`</div>`;
                              NonAttainedPo.innerHTML=str;
                              

                              TotalPso.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][4]}</span></div>`;
                                }
                                 str+=`</div>`;
                                TotalPso.innerHTML=str;

                              AttainedPso.innerHTML=``;
                              str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][5]}</span></div>`;
                                }
                                 str+=`</div>`;
                              AttainedPso.innerHTML=str;


                              NonAttainedPso.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][4]-currentDept[i][5]}</span></div>`;
                                }
                                 str+=`</div>`;
                                NonAttainedPso.innerHTML=str;

                              console.log(Total,Attained);


                              right_i=Lables.length-1;
                              Pindex=Lables.length-1;
                              Pright.style.pointerEvents="none";
                              Pright.style.cursor="default";
                              Pright.style.color="#d3d3d3";
                              right.style.pointerEvents="none";
                              right.style.cursor="default";
                              right.style.color="#d3d3d3";
                              if((right_i-3)<=0){ left_i=0; 
                                left.style.pointerEvents="none";
                                left.style.cursor="default";
                                left.style.color="#d3d3d3";
                              }else{ left_i=(right_i-3)}
                             
                              generate_COChart(Lables.slice(left_i,(right_i+1)),Total.slice(left_i,(right_i+1)),Attained.slice(left_i,(right_i+1)),max);
                              generate_POChart(POArray[Pindex],Lables[Pindex]);
                         }
                        },
                        complete:function(data){
                          // console.log(Lables,Total,Attained);
                        } 
                  });
        }
        get_DashBoard();
        Pleft.addEventListener('click',function(){
              Pindex-=1;
              generate_POChart(POArray[Pindex],Lables[Pindex]);
              if(Pindex==0){
                Pleft.style.pointerEvents="none";
                Pleft.style.cursor="default";
                Pleft.style.color="#d3d3d3"; 
              }
              Pright.style.pointerEvents="auto";
              Pright.style.cursor="pointer";
              Pright.style.color="#000";
        });
        Pright.addEventListener('click',function(){
              Pindex+=1;
              generate_POChart(POArray[Pindex],Lables[Pindex]);
              if(Pindex==(Lables.length-1)){
                 Pright.style.pointerEvents="none";
                Pright.style.cursor="default";
                Pright.style.color="#d3d3d3"; 
              }
              Pleft.style.pointerEvents="auto";
              Pleft.style.cursor="pointer";
              Pleft.style.color="#000";
        });
        left.addEventListener('click',function(){
            left_i-=1;
            right_i-=1;
            generate_COChart(Lables.slice(left_i,(right_i+1)),Total.slice(left_i,(right_i+1)),Attained.slice(left_i,(right_i+1)),max);
            if(left_i==0){
              left.style.pointerEvents="none";
              left.style.cursor="default";
              left.style.color="#d3d3d3"; 
            }

            right.style.pointerEvents="auto";
            right.style.cursor="pointer";
            right.style.color="#000";
            
        });
        right.addEventListener('click',function(){
              right_i+=1;
              left_i+=1;  
              generate_COChart(Lables.slice(left_i,(right_i+1)),Total.slice(left_i,(right_i+1)),Attained.slice(left_i,(right_i+1)),max);
              if(right_i==(Lables.length-1)){
                right.style.pointerEvents="none";
                right.style.cursor="default";
                right.style.color="#d3d3d3";
              }
              left.style.pointerEvents="auto";
              left.style.cursor="pointer";
              left.style.color="#000";
        });  

        let reload=document.getElementById('reload');
        reload.addEventListener('click',function(){
            get_DashBoard();
        });
      //  generate_COChart(['2019-2023','2020-2024','2021-2025','2022-2026','2023-2027'],[480, 230, 470, 210, 330],[400, 340, 550, 480, 170]);
      selectDept.addEventListener('change',function(){
            console.log(this,this.value);
            let idx=departmentArray.indexOf(this.value);
            currentDept=department[idx];
            Total=[];
            Attained=[];
            POArray=[];
            left_i=0;
            right_i=0;
            Pindex=0;
            right.style.pointerEvents="auto";
            right.style.cursor="pointer";
            right.style.color="#000";
            left.style.pointerEvents="auto";
            left.style.cursor="pointer";
            left.style.color="#000";
            Pleft.style.pointerEvents="auto";
            Pleft.style.cursor="pointer";
            Pleft.style.color="#000";
            Pright.style.pointerEvents="auto";
            Pright.style.cursor="pointer";
            Pright.style.color="#000";
                          for(let l=0;l<currentDept.length;l++){
                            Total.push(currentDept[l][0]);
                          }
                          for(let l=0;l<currentDept.length;l++){
                            Attained.push(currentDept[l][1]);
                          }
                          for(let l=0;l<currentDept.length;l++){
                            POArray.push(currentDept[l][6]);
                          }



                          TotalCo.innerHTML=``;
                              let str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][0]}</span></div>`;
                                }

                                str+=`</div>`;
                              TotalCo.innerHTML=str; 

                              AttainedCo.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][1]}</span></div>`;
                                }

                                str+=`</div>`;
                                AttainedCo.innerHTML=str;
                              
                              
                              
                              NonAttainedCo.innerHTML=``;
                               str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][0]-currentDept[i][1]}</span></div>`;
                                }
                                str+=`</div>`;
                              NonAttainedCo.innerHTML=str;
                              

                              TotalPO.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][2]}</span></div>`;
                                }
                                 str+=`</div>`;
                                TotalPO.innerHTML=str;
                              
                              AttainedPo.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][3]}</span></div>`;
                                }
                                 str+=`</div>`;
                                AttainedPo.innerHTML=str;

                              

                              NonAttainedPo.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][2]-currentDept[i][3]}</span></div>`;
                                }
                                 str+=`</div>`;
                              NonAttainedPo.innerHTML=str;
                              

                              TotalPso.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][4]}</span></div>`;
                                }
                                 str+=`</div>`;
                                TotalPso.innerHTML=str;

                              AttainedPso.innerHTML=``;
                              str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][5]}</span></div>`;
                                }
                                 str+=`</div>`;
                              AttainedPso.innerHTML=str;


                              NonAttainedPso.innerHTML=``;
                                str=`<div class ="row">`;
                                for(let i=0;i<Lables.length;i++){
                                      str+=`<div class="custom-batch col-6">${Lables[i]}: <span class="custom-value">${currentDept[i][4]-currentDept[i][5]}</span></div>`;
                                }
                                 str+=`</div>`;
                                NonAttainedPso.innerHTML=str;

                              console.log(Total,Attained);


                              right_i=Lables.length-1;
                              Pindex=Lables.length-1;
                              Pright.style.pointerEvents="none";
                              Pright.style.cursor="default";
                              Pright.style.color="#d3d3d3";
                              right.style.pointerEvents="none";
                              right.style.cursor="default";
                              right.style.color="#d3d3d3";
                              if((right_i-3)<=0){ left_i=0; 
                                left.style.pointerEvents="none";
                                left.style.cursor="default";
                                left.style.color="#d3d3d3";
                              }else{ left_i=(right_i-3)}
                             
                              generate_COChart(Lables.slice(left_i,(right_i+1)),Total.slice(left_i,(right_i+1)),Attained.slice(left_i,(right_i+1)),max);
                              generate_POChart(POArray[Pindex],Lables[Pindex]);

      });
   </script>
  </body>
</html>
