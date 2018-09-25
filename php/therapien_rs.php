<?php
include('d3js/recommendation.html');

function show_therapien_rs($disabled, $connection) {

// Parameter
    $patient = $_SESSION['idPatient'];
    $visite = $_SESSION['idVisite'];
    $visiten = $_SESSION['visiten'];
    $numVisite = array_search($visite, $visiten);
    $therapies = array();
    $numRecom = 3;

    // fetch recommendation
    if (isset($_POST['generiere_therapieempfehlung'])) {
        $sql = mysqli_query($connection, "SELECT * FROM tbltherapiesvisitesystlist WHERE Visite = $visite ORDER BY Score DESC LIMIT $numRecom");
        while ($row = mysqli_fetch_array($sql)) {
            $therapies[$row['Therapie']] = $row['Score'];
        }
    } else {
        // insert visite into input interface if not already in queue
        $sql = mysqli_query($connection, "SELECT * FROM tblinputinterface WHERE Visite = $visite ORDER BY IDInput DESC LIMIT 1");
        $row = mysqli_fetch_array($sql);
        if (empty($row['IDInput'])) {
            // empty table to make sure no old request is in queue
            $sql = mysqli_query($connection, "TRUNCATE TABLE tblinputinterface");
            $retval = mysqli_query($connection, $sql);
            // append new request
            $sql = mysqli_query($connection, "INSERT INTO tblinputinterface(Visite, Patient, NumVisite) VALUES ($visite,$patient,$numVisite)");
            $retval = mysqli_query($connection, $sql);
        }
    }
    ?>


    <form class = "questionblock" method = "post" id = "section_empfehlungarzt" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_empfehlungarzt">

        <div class = "panel panel-primary">
            <!--Default panel contents -->
            <div class = "panel-heading">Vom Therapieempfehlungssystem empfohlene Therapie:</div>
            
            <div id="dashboard"></div>
  <script>
            d3.json("d3js/recommendation.json", function(error, data) {
  if (error) throw error;
  console.log(data.therapyData[0]);
  
//dashboard('#dashboard',data.therapyData,settingsData);
dashboard('#dashboard',therapyData,settingsData);

});
</script>          

        </div>
    </form>


    <?php
}
?>
