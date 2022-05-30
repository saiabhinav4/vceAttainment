<?php
require "../common/connection.php";
if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){
    $branch=$_SESSION['department'];
}
else{
header('location:../../index.php');
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
    <title>Project Templete Preview</title>
    <!-- plugins:css -->
    <!-- <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    /> -->
    <link
      rel="stylesheet"
      href="../../vendors/ti-icons/css/themify-icons.css"
    />
    <!-- <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css" /> -->
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
 
 
    <!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css"> -->



    <style>
      .branch-heading{
        color:#000;
      }
      .main-panel{
        width: 100% !important;
      }
       #loader {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/Hourglass.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }
        /* .custome{
            margin-top: 1rem;         
        }
        .custome1{
          margin-left: 1.2rem;
        } */
        /* td{
          padding-top: 1rem !important;
          height:4rem;
          padding-bottom: 0 !important ;
        } */
        table{
          background-color: whitesmoke;
        }
        iframe{
          width: 100%;
          height:30rem;
          /* background-color: gray; */
        }
      
      iframe #top-bar{
          background-color: #2CD467 !important;
        }
  
        /* .dropdown-menu{
        position: relative !important;

    } */
    </style>
  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include "../common/header1.php"; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php // include "../common/sidenav1.php"; ?>

        <!-- partial -->
        <div class="main-panel"  >
        <form
             method="post"
            action="../scripts/articulationScript1.php"
                          >
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title" style="text-transform:capitalize;">Excel Template For Project (Mini-Project,Project Work-1,Project Work-2) Courses</h4>
                          <!-- <p class="card-description">
                            Enter the facullty details to create an account
                          </p> -->
                          <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRPPs-evuwA98E0syGLlpgg7nG2A26HPVmQaNpG0XSyVa92Nb80-ExTTCeEOpCQZ9b2SxnAVXk2YMJ6/pubhtml?widget=true&amp;headers=false"></iframe>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

  </form>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
         <?php include '../common/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>



    
  
    



    
 
    <!-- container-scroller -->
    <!-- plugins:js -->
      
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>  -->
  
    <script>
      // $(document).ready(function () {
      //   $("#facultyTable").DataTable();
      // });
      
    </script>
   
   <script>


</script>

<!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script> -->

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script> -->

<script src="../../js/jquery.cookie.js" type="text/javascript"></script>

    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
   
  </body>
</html>
