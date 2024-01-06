<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {

  position: fixed;
  top: 0;

}
.topnav2{
  margin-left: auto;
  position: fixed;
  top: 0;
  right: 0;

}

.topnav a, .topnav2 a {
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}
.topnav a:nth-child(1){
  background-color:darkkhaki;
  float: left;
}
.topnav a:nth-child(2){
  background-color:darkolivegreen;
  float: left;
  letter-spacing:0cm;
  word-spacing: 0cm;
}
.topnav2 a:nth-child(1){
  background-color:darkolivegreen;
  float: right;
}
.topnav2 a:nth-child(2){
  background-color:darkkhaki;
  float: right;

}
.topnav a.active {
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<div class="topnav">
  <a href="rawissueto_bobin.php">Raw Transfer to Bobin</a>
  <a href="rawreturnfrom_bobin.php">Raw Return From Bobin</a>



 
</div>
<div class="topnav2">
  
  <a href="rawreturnfrom_pirn.php">Raw Return From Pirn</a>
    <a href="rawissueto_pirn.php">Raw Transfer to Pirn Winding</a>

 </div>

</body>
</html>
