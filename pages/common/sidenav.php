  <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <?php if(($_SESSION['department']=="GlobalAdmin")){ ?>
                <a class="nav-link" href="../../GlobalAdmin.php">
             <?php  }else { ?>
              <a class="nav-link" href="../../admin.php">
                <?php } ?>
                <i class="ti-shield menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item" id="attainments">
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
                  <?php if(($_SESSION['department']=="GlobalAdmin")){ ?>
                    <a class="nav-link" href="GlobalCoattainment.php"
                      >CO Attainments</a
                    >
                    <?php }else{   ?>
                      <a class="nav-link" href="coattainment.php"
                      >CO Attainments</a
                    >
                   <?php } ?>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="poattainment.php"
                      >PO Attainments</a
                    >
                  </li>
                </ul>
              </div>
            </li>
            <?php  if(($_SESSION['department']=="GlobalAdmin")){ ?>
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
                    <a class="nav-link" href="manageHods.php">
                          Modify Hod Account
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php } else{ ?>
            <li class="nav-item" id="Mcourses">
              <a
                class="nav-link"
                data-bs-toggle="collapse"
                href="#manage-course"
                aria-expanded="false"
                aria-controls="manage-course"
              >
                <i class="ti-book menu-icon"></i>
                <span class="menu-title">Manage Courses</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="manage-course">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="coursedetails.php">
                      Course Details
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <?php } if(!($_SESSION['department']=="GlobalAdmin")){ ?>
            <li class="nav-item" id="Mfaculty">
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
                    <a class="nav-link" href="facultydetails.php">
                      Faculty Details
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="mappingfandc.php">
                      Faculty-Course Mapping
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <!-- <li class="nav-item" id="Regulation">
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
                    <a class="nav-link" href="regulation.php">
                      Regulation
                    </a>
                  </li>
                  
                </ul>
              </div>
            </li> -->
            <!-- <li class="nav-item" id="Mweights">
              <a class="nav-link" href="weightage.php">
                <i class="ti-layout-list-post menu-icon"></i>
                <span class="menu-title">Modify Weightages</span>
              </a>
            </li> -->
            <li class="nav-item" id="Ipoassessment">
              <a class="nav-link" href="indirectpos.php">
                <i class="ti-pie-chart menu-icon"></i>
                <span class="menu-title">PO Indirect Assessment</span>
              </a>
            </li>
            <?php } ?>
            <li class="nav-item" id="Mweights">
              <a class="nav-link" href="weightage.php">
                <i class="ti-layout-list-post menu-icon"></i>
                <span class="menu-title">Modify Weightages</span>
              </a>
            </li>
            <?php if(($_SESSION['department']=="GlobalAdmin")){  ?>
            <li class="nav-item">
                    <a class="nav-link" href="regulation.php">
                    <i class="ti-info-alt menu-icon"></i>
                <span class="menu-title">Regulation</span>
                    </a>
            </li>
            <?php } ?>
          </ul>
        </nav>