<?php

function show_komorbiditaeten() {
    $select = 0;
    ?>

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Jemals angewendete Therapien:</div>

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>Komorbidität</th>
                    <th>Liegt vor</th>
                    <th>Wird behandelt</th>
                    <th>Erkrankungsfrei seit</th>
                    <th>Löschen</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $visite = $_SESSION['idVisite'];
                $results = mysql_query("SELECT * FROM tblKomorbiditaetenVisite INNER JOIN tblKomorbiditaeten ON tblKomorbiditaetenVisite.Komorbidität = tblKomorbiditaeten.IDKomorbiditäten LEFT JOIN tblKomorbiditaetLiegtVor ON tblKomorbiditaetenVisite.LiegtVor = tblKomorbiditaetLiegtVor.IDLiegtVor WHERE Visite = $visite");
                while ($row = mysql_fetch_array($results)) {
                    ?>
                    <tr>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['txtLiegtVor'] ?></td>
                        <td><?php if ($row['WirdBehandelt']) echo "ja"; ?></td>
                        <td><?php echo $row['ErkrankungsfreiSeit'] ?></td>

                        <td style="text-align: right;">
                            <button type="submit" class="btn btn-danger" name="loeschen[<?php echo $row['IDTherapieExperte'] ?>]" value="x">
                                <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                            </button>
                        </td>

                    </tr>

                    <?php
                }
                ?>
            </tbody>
        </table>

    </div>

    <?php
    if ($select == 0) {
        ?>
        <div class="panel panel-primary">

            <form class="questionblock" action="" method="post">
                <!--<form action="" method="post">-->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group" style="margin: 5px">
                            <span class="input-group-addon" id="basic-addon1">Komorbidität:</span>
                            <div class="form-group">
                                <select class="form-control" id="sel1" name="therapie">
                                    <option selected></option>
                                    <?php
                                    foreach ($therapies as $i => $val) {
                                        echo "<option value=\"$i\">$val</option>";
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->

                    <div class="col-lg-6">
                        <div class="input-group" style="margin: 5px">
                            <span class="input-group-addon" id="basic-addon1">Liegt vor:</span>
                            <div class="form-group">
                                <select class="form-control" id="sel1" name="verabreichung">
                                    <option selected></option>
                                    <?php
                                    foreach ($verabreichungen as $i => $val) {
                                        echo "<option value=\"$i\">$val</option>";
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
                            <span class="input-group-addon" id="basic-addon1">Erkrankungsfrei seit:</span>
                            <input type="number" value="" min="0" max="100000" class="form-control" placeholder="" aria-describedby="basic-addon1" name="dosierung">
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group" style="margin: 5px">
                            <span class="input-group-addon" id="basic-addon1">Wird behandelt:</span>
                            <div class="form-group">
                                <select class="form-control" id="sel1" name="masseinheit">
                                    <option selected></option>
                                    <?php
                                    foreach ($masseinheiten as $i => $val) {
                                        echo "<option value=\"$i\">$val</option>";
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->

                </br>

                <div class="row">
                    <div class="col-lg-6" style="text-align: right;">
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6" style="text-align: right;">

                        <a href="#liste" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>

                        <button type="submit" class="btn btn-success btn-lg" name="speichern" value="Therapieempfehlung speichern">
                            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                        </button>

                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->

            </form>
        </div><

        <?php
    }
}
?>