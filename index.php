
<!doctype html>
<html lang="en">
  <head>
    <title>Káve</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta charset="UTF-8">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>


<?php


if (isset($_POST["action"]) and $_POST["action"]=="cmd_insert_kave")
{
  
    $kavefelvetel = new adatbazis();
    $kavefelvetel->kave_felvetel( $_POST["input_kave_name"], $_POST["input_kave_price"],$_POST["input_kave_milk"], $_POST["input_kave_content"]);
    
  
}

if (isset($_POST["action"]) and $_POST["action"]=="cmd_updateform_kave")
  {
  if(isset($_POST["input_id"]) and !empty($_POST["input_id"]))
    {
      $kave_modositas_urlap = new adatbazis();
      $kave_modositas_urlap->updateform_kave($_POST["input_id"]);
    }
}


if (isset($_POST["action"]) and $_POST["action"]=="cmd_update_kave")
{
if(isset($_POST["input_kave_name"]) and !empty($_POST["input_kave_name"]) and
   isset($_POST["input_kave_price"]) and !empty($_POST["input_kave_price"]) and
   isset($_POST["input_kave_milk"]) and !empty($_POST["input_kave_milk"]) and
   isset($_POST["input_kave_content"]) and !empty($_POST["input_kave_content"]) and 
   isset($_POST["input_id"]) and !empty($_POST["input_id"]))
{
  $kavemodositas = new adatbazis();
  $kavemodositas->update_kave($_POST["input_id"], $_POST["input_kave_name"], $_POST["input_kave_price"],$_POST["input_kave_milk"], $_POST["input_kave_content"]);
  
}
}



if (isset($_POST["action"]) and $_POST["action"]=="cmd_delete_kave")
{
  if(isset($_POST["input_id"]) and !empty($_POST["input_id"]))
  {
    $kavetorles = new adatbazis();
    $kavetorles->kave_torles($_POST["input_id"]);
  }
}


$kavelista = new adatbazis();
$kavelista->kave_lista();


class adatbazis{
public $servername = "localhost";
public $username = "root";
public $password = "";
public $dbname = "kave";	
public $conn = NULL;
public $sql = NULL;
public $result = NULL;
public $row = NULL;
//public $table = "table table-striped"; //table-hover, table-striped
//public $col = "col";


public function __construct(){ $this->kapcsolodas(); }
public function __destruct(){ $this->kapcsolatbontas(); }

public function kapcsolodas(){
  // Create connection
  $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  // Check connection
  if ($this->conn->connect_error) {
    die("Connection failed: " . $this->conn->connect_error);
  }

  $this->conn->query("SET NAMES UTF8;");		
}

public function kapcsolatbontas(){
  $this->conn->close();
}



public function kave_felvetel($kave_neve,$kave_ar, $kave_tejese, $kave_leirasa){
  
  $this->sql = "INSERT INTO kavek
          (
            id,
            nev,
            ar,
            tejese,
            leiras
          )
          VALUES
          (
            NULL,
            '$kave_neve',
            '$kave_ar', 
            '$kave_tejese', 
            '$kave_leirasa'
          );";
  if ($this->conn->query($this->sql)){
    echo "<p>Sikeres Kávé hozzá adása a listához!</p>";
  } else {
    echo "<p>Sikertelen kávé felvétel!</p>";
  }
}



public function kave_lista(){
  $this->sql = "SELECT `id`, `nev`, `ar`, `tejese`, `leiras` FROM `kavek` WHERE 1";
  $this->result = $this->conn->query($this->sql);

  if ($this->result->num_rows > 0) {
    
    echo "<table class='table table-striped'>";
    echo "<tr> <thead>";
    
      echo "<th scope='col'>ID</th>";
      echo "<th scope='col'>Név</th>";
      echo "<th scope='col'>Ár</th>";
      echo "<th scope='col'>Van-e benne tej?</th>";
      echo "<th scope='col'>leírás</th>";
      echo "<th></th>";
      echo "<th></th>";
    echo "</tr> </thead>";
      while($this->row = $this->result->fetch_assoc()) {
      echo "<tr>";
        echo "<td >" . $this->row["id"]. "</td>";
        echo "<td>" . $this->row["nev"]. "</td>";
        echo "<td>" . $this->row["ar"]. "</td>";
        echo "<td>";
          echo (($this->row["tejese"]==0)?"nem":"igen");					
        echo "</td>";
        echo "<td>" . $this->row["leiras"]. "</td>";
        echo "<td>";
            echo "<form method='POST' style='display: inline;'>
              <input type='hidden' name='input_id' value='" . $this->row["id"]. "'>
              <input type='hidden' name='action' value='cmd_updateform_kave'>
              <input type='submit' value='Módosítás'>
              </form>";						
        echo "</td>";		
        echo "<td>";
            echo "<form method='POST' style='display: inline;'>
              <input type='hidden' name='input_id' value='" . $this->row["id"]. "'><br />
              <input type='hidden' name='action' value='cmd_delete_kave'>
              <input type='submit' value='Törlés'>
              </form>";						
        echo "</td>";					
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "0 results";
  }		
}


public function updateform_kave($id){
  $this->sql = "SELECT `id`, `nev`, `ar`, `tejese`, `leiras` FROM `kavek` WHERE `id` = $id";
  $this->result = $this->conn->query($this->sql);

  if ($this->result->num_rows > 0) {
    
    echo "<table  class='table-secondary'>";
      while($this->row = $this->result->fetch_assoc()) {
      echo "<fieldset><legend>Módosítás űrlap</legend><form method='POST'>
        Név: 
        <input type='text' name='input_kave_name'	value='" . $this->row["nev"]. "'><br />
        Ár: <input type='number' name='input_kave_price' value='" . $this->row["ar"]. "'><br />
        Van-e benne tej (1 ha igen, 0 ha nem): <input type='number' name='input_kave_milk'  value='0'><br />
        Leiras: <br /><textarea name='input_kave_content'>" . $this->row["leiras"]. "</textarea><br />

        <input type='hidden' name='input_id' value='" . $this->row["id"]. "'>
        <input type='hidden' name='action' value='cmd_update_kave'>
        <input type='submit' value='Módosítás'>
      </form></fieldset>";				
    }
    echo "</table>";
  } else {
    echo "0 results";
  }
}
public function update_kave($id, $kave_neve,$kave_ar, $kave_tejese, $kave_leirasa){
  $this->sql = "UPDATE 
            kavek
          SET	
              ar = '$kave_ar',
            tejese = '$kave_tejese',
            nev = '$kave_neve', 
            leiras = '$kave_leirasa'
          WHERE 
            id = $id";
  var_dump($this->sql);
  if ($this->conn->query($this->sql)){
    echo "<p>Sikeres adatmódosítás!</p>";
  } else {
    echo "<p>Sikertelen adatmódosítás!</p>";
  }		
}

public function kave_torles($id){
  $this->sql = "DELETE FROM `kavek` WHERE `kavek`.`id` = $id";
  
  if ($this->conn->query($this->sql)){
    echo "<p>Sikeres törlés!</p>";
  } else {
    echo "<p>Sikertelen törlés!</p>";
  }		
}

}


?>



<br>
<br>

<div class="input-group mb-3">
<form method="POST">

Név: 	<input type='text'  class="form-control" name='input_kave_name'><br />
Ár: <input type='number'  class="form-control" name='input_kave_price'><br />
Van-e benne tej (1 ha igen, 0 ha nem): <input type='number' name='input_kave_milk' class="form-control"><br />
Leiras: <br /><textarea name='input_kave_content'  class="form-control"></textarea><br />
<input type='hidden' name='action' value='cmd_insert_kave'>
<input type='submit' value='Felvétel'>
</form>
</div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="jquery.min.js"></script>
    <script src="scripts.js"></script>
  </body>
</html>