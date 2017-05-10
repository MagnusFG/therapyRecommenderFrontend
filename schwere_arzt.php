<?php

function show_schwere_arzt($disabled) {

    // Daten Visite
    $visite = $_SESSION['idVisite'];
    $results = mysql_query("SELECT * FROM tblPasiVisite WHERE Visite = $visite");
    $row = mysql_fetch_array($results);
    $pasi = $row['PasiScore'];
    ?>

    <form class="questionblock" method="post" id="section_einschaetzungarzt" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#section_einschaetzungarzt">
    

        <div class="panel panel-primary">

            <div style="float: right; margin: 5px">
                <button type="submit" class="btn btn-success btn-md" name="speichern_pasi" value="speichern_pasi"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
            </div> 

            <div class="panel-heading">Psoriasis Area and Severity Index (PASI):</div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group" style="margin: 5px">
                        <span class="input-group-addon" id="basic-addon1">PASI Score:</span>
                        <input type="number" <?php echo $disabled; ?> value="<?php echo $pasi; ?>" class="form-control" placeholder="" aria-describedby="basic-addon1">
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->                    
            </div><!-- /.row -->     

            </br>
            </br>

            <div style="margin: 5px;">
                <button class="btn btn-primary " type="button" data-toggle="collapse" data-target="#collapsePasiCalculator" aria-expanded="false" aria-controls="collapsePasiCalculator" <?php echo $disabled; ?>>
                    PASI Score Detail
                </button>            
            </div>                

            <div class="collapse" id="collapsePasiCalculator">
                <div class="card card-block">

                    </br>

                    <p style="margin: 5px">Kopf / Hals:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">Stamm:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">Arme:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row --> 

                    </br>

                    <p style="margin: 5px">Beine/Gesäß:</p>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Rötung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Infiltration:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Schuppung:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiIndikator'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="input-group" style="margin: 5px">
                                <span class="input-group-addon" id="basic-addon1">Fläche:</span>
                                <div class="form-group">
                                    <select <?php echo $disabled; ?> class="form-control" id="sel1">
                                        <?php
                                        $selected = '';
                                        $results = mysql_query("SELECT * FROM tblPasiScore");
                                        echo "<option disabled selected value></option>";
                                        while ($rowTmp = mysql_fetch_array($results)) { // while Antworten ausgeben
                                            $valTmp = $rowTmp['intPasiScore'];
                                            $nameTmp = $rowTmp['txtPasiFläche'];
                                            echo "<option $selected value=\"$valTmp\">" . $nameTmp . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->                    
                    </div><!-- /.row --> 
                </div>
            </div>
        </div>
    </form>

    <?php
}
?>