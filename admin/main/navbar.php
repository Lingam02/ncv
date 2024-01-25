<nav class="navbar navbar-expand-lg  py-0 px-1 non-print">
  <div class="d-flex align-items-center"id="menu-toggle" >
    <i class="fas fa-align-left text-dark fs-4 me-3" id="menu-toggle"></i>
    <h2 class="fs-4 m-0 text-dark text-uppercase" >NC Vardhan Silks - 2024</h2>
  </div>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" id="navbarDropdown" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <!-- <i class="fas fa-user me-2"></i> -->
          <i class="fas fa-user me-2"></i><?php echo $_SESSION['uname']; ?>

        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li> -->
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>