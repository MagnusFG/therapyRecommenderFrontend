<?php

function show_komorbiditaeten() {
    ?>


    <form class="questionblock" action="" method="post">

        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Komorbidität</th>
                        <th>Liegt vor</th>
                        <th>Wird behandelt</th>
                        <th>Erkrankungsfrei seit</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $visite = $_SESSION['idVisite'];
                    $results = mysql_query("SELECT * FROM tblKomorbiditaetenVisite INNER JOIN tblKomorbiditaeten ON tblKomorbiditaetenVisite.Komorbiditaet = tblKomorbiditaeten.IDKomorbiditaeten INNER JOIN tblKomorbiditaetLiegtVor ON tblKomorbiditaetenVisite.LiegtVor = tblKomorbiditaetLiegtVor.IDLiegtVor WHERE Visite = $visite");
                    while ($row = mysql_fetch_array($results)) {
                        ?>
                        <tr>
                            <td><?php echo $row['txtName'] ?></td>
                            <td><?php echo $row['txtLiegtVor'] ?></td>
                            <td><?php if ($row['WirdBehandelt']) echo "ja";?></td>
                            <td><?php echo $row['ErkrankungsfreiSeit'] ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </form>

    <?php
}
?>