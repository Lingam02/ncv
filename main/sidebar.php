<div class="bg-white non-print" id="sidebar-wrapper">
  <div class="sidebar-heading text-bottom primary-text  fw-bold  border-bottom"> <img class="pcw" src="img/PCW.ico" alt=""> AcPro</div>
  <div id="01">
  <div href="#" class="list-group-item list-group-item-action second-text fw-bold dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#togglefour"><i class="fas fas fa-layer-group me-2"></i>Basic Creations
  </div>
 
  <div class="collapse" id="togglefour">
    <input type="hidden" id="u_type" name="u_type" value=" <?php echo $_SESSION['ADMIN']; ?>">
 
    <a href="user.php">User Creation</a>
    <a href="colour_creation.php">Create Colour</a>
    <a href="stores.php">Create Stores</a>
    <a href="bobin.php">Bobin Setup </a>
    <a href="box.php">Create Pirn Box </a>
    <a href="createblock.php">Create Block</a>
    <a href="workunit.php">Create Unit</a>

  </div>
  <div href="#" class="list-group-item list-group-item-action second-text fw-bold dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#toggle_opn"><i class="fas fas fa-layer-group me-2"></i>Openings
  </div>
  <div class="collapse" id="toggle_opn">

    <a href="opening1.php">Opening</a>
    <a href="opening2.php">Opening Bobin Type</a>
    <a href="opening3.php">Opening Pirn Type</a>


  </div>
  
  </div>
  <div class="list-group list-group-flush my-3">
    <a href="admin.php" class="list-group-item list-group-item-action second-text active"><i class="fas fa-home me-2"></i>Home</a>
    <a href="dyer_form.php" class="list-group-item list-group-item-action second-text "><i class="fas fa-home me-2"></i>Dyer</a>
    <!-- <a href="seperation.php" class="list-group-item list-group-item-action second-text "><i class="fas fa-home me-2"></i>Seperation</a> -->
    <!-- <a href="sizeing.php" class="list-group-item list-group-item-action second-text "><i class="fas fa-home me-2"></i>Sizeing</a> -->
    <!-- <a href="dyer.php" class="list-group-item list-group-item-action second-text "><i class="fas fa-home me-2"></i>Dyer</a> -->
    <!-- <a href="dyer_ret.php" class="list-group-item list-group-item-action second-text "><i class="fas fa-home me-2"></i>Dyer Ret</a> -->
    <!-- <a href="user.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>User Creation</a>
    <a href="colour_creation.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>Create Colour</a>
    <a href="createblock.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>Create Block</a>
    <a href="workunit.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>Create Unit</a> -->
    <a href="rawissueto_bobin.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fa-arrow-right me-2"></i>Transfer to <span style="color:blue">Bobin</span></a>
    <a href="rawreturnfrom_bobin.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fa-arrow-left me-2"></i>Return from <span style="color:blue">Bobin</span></a>

    <a href="rawissueto_pirn.php" class="text-nowrap list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-arrow-right me-2"></i>Transfer bobin to <span style="color:orange">Pirn</span></a>
    <a href="rawreturnfrom_pirn.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-arrow-left me-2"></i>Return from <span style="color:orange">Pirn</span></a>

    <a href="weaverissue.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-arrow-right me-2"></i>Transfer to <span style="color:blue">Loom</span></a>

    <a href="weaver_return.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-arrow-left me-2"></i>Return From <span style="color:blue">Loom</span></a>
    <a href="saree_rec.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fa-layer-group me-2"></i>Saree Receipt</a>

    <a href="index.php" class="list-group-item list-group-item-action text-danger fw-bold"><i class="fas fa-power-off me-2"></i>Logout</a>
    <!-- <a href="report.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>Report</a>
    <a href="weaver_report.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>Single User Report</a>
    <a href="stock_report.php" class="list-group-item list-group-item-action second-text fw-bold"><i class="fas fas fa-layer-group me-2"></i>Stock Report</a> -->
    <div href="#" class="list-group-item list-group-item-action second-text fw-bold dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#report_toggle"><i class="fas fas fa-file me-2"></i>Basic Reports
  </div>
  <div class="collapse" id="report_toggle">

    <a href="opening_report1.php"> Openings</a>
    <a href="opening_report2.php">Bobin Type Openings</a>
    <a href="opening_report3.php">Pirn Type Openings</a>
    <a href="user_list.php">User list</a>
    <!-- <a href="r_bobin_trans.php">Bobin Transaction</a> -->
    <a href="r_dyer.php">Dyer Transaction</a>


  </div>
  </div>

</div>