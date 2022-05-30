 <!-- partial:partials/_navbar.html -->
 <?php //include 'connection.php'; ?>
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
              <h4 class="branch-heading"><?php if($_SESSION['department']=="GlobalAdmin"){ echo "PRINCIPAL"; } else{ echo "Department of ".get_department($branch); }  ?></h4>
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
                <img src="../../images/faces/admin.jpg" alt="profile" />
              </a>
              <div
                class="dropdown-menu dropdown-menu-right navbar-dropdown"
                aria-labelledby="profileDropdown"
              >
            <?php  if(!($_SESSION['department']=="GlobalAdmin")){ ?>
              <a class="dropdown-item" style="border-bottom:1px solid rgba(0,0,0,0.2);" >
                  <!-- <i class="ti-power-off text-primary"></i> -->
                  <?php 

                        $des=$branch."-HOD";
                        $select_fid="select facultyID from faculty where designation='$des'";
                        $res=mysqli_query($con,$select_fid) or die(mysqli_error($con));
                        if(mysqli_num_rows($res)>0){
                           $row=mysqli_fetch_row($res);
                           $facultyId=$row[0];
                           if(!empty($facultyId)){
                               $retrive="select fname,facultyID from faculty where facultyID='$facultyId' and isspecial=0";
                               $result=mysqli_query($con,$retrive) or die(mysqli_error($con));
                               if(mysqli_num_rows($result)>0){
                                    $row=mysqli_fetch_row($result);
                                    echo "$row[0] - $row[1]";
                               }else{
                                  echo "$branch-HOD";
                               }
                           }
                           else{
                              echo "$branch-HOD";
                           }
                        }

                  ?>
                </a>
                <?php } ?>
                <a class="dropdown-item" href="../../logout.php">
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