<!-- <nav class="navbar navbar-expand-lg  py-0 px-1 non-print">
  <div class="d-flex align-items-center"id="menu-toggle" >
    <i class="fas fa-align-left text-dark fs-4 me-3" id="menu-toggle"></i>
    <h2 class="fs-4 m-0 text-dark text-uppercase" >NC Vardhan Silks - 2024</h2>
  </div>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="form-group d-flex ms-4 mt-2">
                                     <input type="date" name="iss_date" id="iss_date" class="form-control">
                                     <input type="text" class="form-control shadow-none ms-2" id="currentTime" name="currentTime" readonly >

                                 </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" id="navbarDropdown" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user me-2"></i>

        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav> -->
<div class="container-fluid p-2 bg-nav mb-2 shadow ">
  <div class="row">
    <div class="col-lg-5 col-sm-12 ">
      <div class="d-flex align-items-center" id="menu-toggle">
        <i class="fas fa-align-left fs-4 me-3" id="menu-toggle"></i>
        <h3 class="fs-5 m-0">NC Vardhan Silks - 2024</h3>
      </div>
    </div>
    <!-- <div class="col-lg-6 col-sm-12 bg-secondary"> -->

    <!-- <div class="year_gstin"> -->
    <div class="child1 col-lg-3">
      <span class="nav_color">
      <input type="date" name="iss_date" id="iss_date" class="form-control">

      </span>
    </div>
    <div class="child2 col-lg-3">
    <input type="text" class="form-control shadow-none ms-2" id="currentTime" name="currentTime" readonly >

    </div>
    <!-- </div> -->
    <!-- </div> -->
    <div class="col-lg-1 col-sm-12 ">
      <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> -->

                                

      <i class="fas fa-user me-2 nav_color"></i><span class="nav_color"><?php echo $_SESSION['uname']; ?></span>

      <!-- <a class="dropdown-item" href="logout.php">Logout</a> -->



    </div>
  </div>
</div>