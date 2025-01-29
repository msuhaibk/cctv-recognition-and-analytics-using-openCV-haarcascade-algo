<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta http-equiv="refresh" content="">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <title>Sales And customer Information</title>
  <style>
    body {
      /* padding:50px; */
      position: fixed;
      margin: 0;
      width: 100%;
      height: 100%;
      background: rgb(250, 250, 250);
    }

    main {
      margin-top: 0px;
    }

    .boxo-container {
      width: 100%;
      height: 300px;
      display: flex;
      background: white;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      box-shadow: -2px 2px 10px rgba(39, 39, 39, 0.134);
      border-radius: 25px;
      transition: all 0.2s;
      cursor: pointer;
    }

    .boxo-container:hover {
      box-shadow: 0px 0px 2px rgba(39, 39, 39, 0.263);
      /* transform: rotateX(185deg); */

    }

    .boxo-container:hover .boxo-title {
      color: red;
      font-size: 2em;

    }

    .boxo-container:hover .boxo {
      transform: scale(0.9, 0.9);
    }

    .boxo-title {
      margin-top: 8px;
      font-size: 1.7em;
      color: rgb(90, 90, 90);
      font-family: Arial, Helvetica, sans-serif;
      font-weight: 900;
      transition: all 0.2s;

    }

    .boxo {
      background: rgb(255, 255, 255);
      background-size: cover;
      background-position: center;
      width: 200px;
      height: 200px;
      transition: all 0.2s;

    }
  </style>


</head>

<body>
  <?php                 

class MyDB extends SQLite3 {
  function __construct() {
     $this->open('face.db');
  }
}
$db = new MyDB();
if(!$db) {
  echo $db->lastErrorMsg();
} else {
  echo "\n";


//SQLITE_ASSOC
}


$query = "SELECT count(id) FROM userdetails WHERE status=1;";
$result = $db->query($query);
$row=$result->fetchArray();
echo"
 <div>
                    <nav class='navbar navbar-expand-md navbar-dark fixed-top bg-dark'>
                      <div style='width:45%; height:100%; text-align:center;'>
                      <a class='navbar-brand m-left' href='#'>Active People ({$row[0]})</a>
                      </div>
                      <div style='width:55%; height:100%; text-align:end;'>
                      ";

                      ?>

  <?php 

$page=$_GET['page'];

if($page!=1)
{
  echo ' <a class="navbar-brand" href="?page=1"> <button type="button" class="btn btn-info m-right"><i class="fa fa-bar-chart"></i> Report</button></a>';

}
else {
  echo ' <a class="navbar-brand" href="/#"> <button type="button" class="btn btn-light m-right">Return</button></a>';

}
            ?>
  </div>
  </nav>
  </div>
  <?php 

$page=$_GET['page'];

if($page!=1)

{


echo'

                  <main style="position: fixed; top:56px; width:100%; height: calc(100% - 56px);">
                    <!-- Search form -->



                      <div style="position: absolute; width:45%; top:0; left:0; height: 100%; overflow-y:auto;">
                          <br/>
                          <div style="margin-left:40px;">
                          <form class="form-inline">
                              <i class="fa fa-search" aria-hidden="true"></i>
                              <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
                                aria-label="Search">
                                <span style="margin-left:15px;"><button type="button" class="btn btn-info m-right"><i class="fa fa-sort" ></i> Sort</button></span>
                            </form>
                          </div>
                          <br/>
';

                      
  $query = "SELECT * FROM userdetails WHERE status=1;";
                         
   $result = $db->query($query);
   if (!$result) 
   echo("Cannot execute query.");
    else{
       echo("") ;
  
    while($row=$result->fetchArray()){
echo"\n";
echo"
    <div id='{$row['id']}' class='listitem' style='margin-top:10px; cursor:pointer; width: 100%; position: relative; display: flex; justify-content: baseline; height:90px; background: linear-gradient(to bottom right,rgb(241, 241, 241),rgb(255, 255, 255)); border:1px solid rgb(241, 241, 241);'>
                          <div style='height: 70px; margin:10px 20px; width:70px; background:url({$row['photo']} ); border-radius: 100%; overflow: hidden; background-size: cover; '></div>
                          <div style=' background: rgba(255, 255, 255, 0);  font-size: 22px; color:rgb(49, 49, 49); font-weight: 900;'>ID |   {$row['id']}    <br/><span style='font-size: 20px; font-weight: 700;'>{$row['username']} </span></div> 
                          <br/>
                          <div style='position: absolute; height: 50px; right:10px; top:5px;'>Time : 19:43</div>
                        </div>
                        ";
                    }
                }
                
                                    
                         
                       
                    
                echo'

                      </div>

                      <div style="position: absolute; width:55%; top:0; right:0; height: 100%; overflow-y:auto; background:rgb(245, 245, 245);">
                          <br/><br/>

                          ';
    
                         class DB extends SQLite3 {
                            function __construct() {
                               $this->open('face.db');
                            }
                         }
                         $db = new DB();
                         if(!$db) {
                            echo $db->lastErrorMsg();
                         } else {
                            echo "\n";
                         
                       
                         //SQLITE_ASSOC
                      }
                      $id=$_GET['id'];
                      if(!$id){

                      }
                      else{


                     
                      $query = "SELECT * FROM userdetails WHERE id=$id;";
                      // $query1 ="SELECT * FROM userbrand WHERE id=$id";
                      $query1= "SELECT max(amount),min(amount) FROM uservalue WHERE id=$id";
                      $query2= "SELECT brands from userbrands where id=$id";
$r = $db->query($query);
$r1 = $db->query($query1);
$r2 = $db->query($query2);
$row=$r->fetchArray();
$row2=$r1->fetchArray();



   echo("") ;
//    $row = sqlite_fetch_array($result, SQLITE_ASSOC); 
//    foreach($res as $result){
//        echo"$res->id\n";
          echo"                

   <div style='width:80%; height:300px; margin: auto; position: relative; border-radius: 20px; border:2px solid rgb(223, 223, 223); background:rgb(245, 245, 245);'>
    <div style='position: relative;'>
    <div style=' height:250px; position: absolute; display: flex; align-items:center; justify-content: center; flex-direction: column; top:0; left:0; width:40%; background:rgba(32, 65, 48, 0);  '>
    <div style='height: 150px; width:150px; background:url({$row[5]}); border-radius: 100%; overflow: hidden; background-size: cover; '></div>
    <div style='height: 50px; width: 100%; background: rgba(255, 255, 255, 0); text-align: center; font-size: 22px; color:rgb(80, 80, 80); font-weight: 900;'> {$row[1]}</div>
    
    </div>
    <div style=' height:250px; position: absolute; top:0; right:0; width:60%; background:rgba(163, 163, 163, 0); padding: 10px; box-sizing: border-box;'>
  <div style='width:max-content; margin: auto; font-weight: 700; color: rgb(95, 95, 95)'>  
    <h3>Customer Id : {$row[0]}</h3>
    <p>joining Date : {$row[6]}</p>
    <p>Phone : {$row[3]}</p>
    <p>Email : {$row[4]}</p>
    <p>Budget Range :{$row2[1]}-{$row2[0]} </p>
    <p>Visits : {$row[2]}</p>
  </div>

    </div>
  </div>
    <div style='height: 50px; width:100%; position: absolute; font-size: 20px;  color:rgb(133, 163, 99); font-weight: 800; bottom:0; background:rgba(255, 192, 203, 0);'>
      <div style='padding: 9px; background: white;
      border: 2px solid #e4e4e4;
      width: fit-content;
      transform: scale(1.03);'>
      Brands Preferred :"; 
      while($row3=$r2->fetchArray()){
        if (!$r) 
        echo("Cannot execute query.");
        else{
      echo"    
      {$row3[0]}
      , ";
    }
  }

      echo"
    </div>
      </div>
   </div>";

}

}

else {
  echo'
  <br/><br/><br/>
  <div style="
  width: 90%;
  display: flex;
  position: fixed;
  height: 90%;
  margin:auto;
  justify-content: space-evenly;
  ">
  
<div id="donutchart" style="width: 45%; height: auto;"></div>
<div id="chart_div" style="width: 55%; height: auto;"></div>

   </div>
  
  ';
}

?>
  <br />
  <br />

  </div>


  </main>

</body>
<script>
  $(document).ready(function () {


    $('div.listitem').click(function () {
      var id = $(this).attr('id');
      window.location.href = "?id=" + id;
    });

  });
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', { 'packages': ['corechart'] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Weeks', 'Puma', 'Redtape', 'Reebok', 'Woodland', 'crocodile'],
      ['week 1', 1000, 400, 200, 400, 600],
      ['week 2', 1170, 460, 200, 400, 600],
      ['week 3', 660, 1120, 400, 400, 600],
      ['week 4', 1030, 540, 600, 400, 600]
    ]);

    var options = {
      title: 'Brands Sales Gradient',
      hAxis: { title: 'Weeks', titleTextStyle: { color: '#333' } },
      vAxis: { minValue: 0 }
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);


  }
  google.charts.setOnLoadCallback(drawdChart);

  function drawdChart() {
    var datad = google.visualization.arrayToDataTable([
      ['Brands', 'Sales'],
      ['Puma', 11],
      ['Redtape', 2],
      ['Reebok', 2],
      ['Woodland', 2],
      ['Crocodile', 5]

    ]);

    var optionsd = {
      title: 'Brands Popularity',
      pieHole: 0.3,
    };

    var chartd = new google.visualization.PieChart(document.getElementById('donutchart'));
    chartd.draw(datad, optionsd);
  }



</script>

</html>