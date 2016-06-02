<?php

function show_therapien_erfolgt() {
    ?>

<form class="questionblock" action="" method="post">

                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>Id</th>
                            <th>Komorbidität</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $results = mysql_query("SELECT * FROM tblKomorbiditaeten LIMIT 10");
                        while ($row = mysql_fetch_array($results)) {
//                            print_r($row);
                            ?>
                            <tr>
                                <td><?php echo $row['IDKomorbiditaeten'] ?></td>
                                <td><?php echo $row['txtName'] ?></td>
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