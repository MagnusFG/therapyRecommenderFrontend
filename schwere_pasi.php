<?php

function show_schwere_pasi() {

    // Daten Visite
    $visite = $_SESSION['idVisite'];
    $results = mysql_query("SELECT * FROM tblPasiVisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $pasi = $row['PasiScore'];
    ?>

    <form class="questionblock" action="" method="post">

        <p>PASI Score:</p>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">PASI:</span>
                    <input type="number" disabled value="<?php echo $pasi; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row -->     

        </br>
        </br>

        <div class="row">
            <div class="col-lg-6">
                <p>Kopf / Hals:</p>
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <p>Stamm:</p>
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['HalsRötung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['StammRötung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row -->

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['HalsInfiltration'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>                                                        <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['StammInfiltration'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['HalsSchuppung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['StammSchuppung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['HalsFlaeche'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['StammFlaeche'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <p>Arme:</p>
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <p>Beine / Gesäß:</p>
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['ArmeRötung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['BeineRötung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row -->

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['ArmeInfiltration'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>                                                        <!--<input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1">-->
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['BeineInfiltration'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['ArmeSchuppung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['BeineSchuppung'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

        </br>

        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['ArmeFlaeche'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                    <div class="form-group">
                        <select disabled class="form-control" id="sel1">
                            <?php
                            $val = $row['BeineFlaeche'];
                            echo "<option selected>$val</option>";
                            ?>
                        </select>
                    </div>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->                    
        </div><!-- /.row --> 

    </form>
    <?php
}
?>