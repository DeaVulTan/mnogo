<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <title></title>
    </head>
    <body>
        <table>
            <tr>
                <th>soft_title</th>
                <th>soft_license</th>
            </tr>
            <?php
            $db = mysql_connect('localhost', 'softstream', 'cjanbyf');
            mysql_select_db('softstream', $db);

            $query = "SELECT `title`,`parent_item`,`license` FROM `files` ORDER BY `title`";
            $result = mysql_query($query, $db) or die("Error SELECT: " . mysql_error());

            while ($row = mysql_fetch_assoc($result)) {
                switch($row['license']) {
                    case "1":
                        $row['license'] = "Shareware";
                        break;

                    case "2":
                        $row['license'] = "Free";
                        break;

                    case "3":
                        $row['license'] = "Demo";
                        break;

                    case "4":
                        $row['license'] = "Adware";
                        break;

                    case "5":
                        $row['license'] = "Trial";
                        break;

                    default:
                        if ($row['parent_item'] != 0) {
                            $lQuery = "SELECT `license` FROM `files` WHERE `id` = " . $row['parent_item'];
                            $lResult = mysql_query($lQuery, $db) or die("ERROR l: " . mysql_error());
                            $lRow = mysql_fetch_assoc($lResult);
                            switch($lRow['license']) {
                                case "1":
                                    $row['license'] = "Shareware";
                                    break;

                                case "2":
                                    $row['license'] = "Free";
                                    break;

                                case "3":
                                    $row['license'] = "Demo";
                                    break;

                                case "4":
                                    $row['license'] = "Adware";
                                    break;

                                case "5":
                                    $row['license'] = "Trial";
                                    break;

                                default:
                                    $row['license'] = "Shareware";
                                    break;
                            }
                        }
                        else 
                            $row['license'] = "Shareware";
                        break;
                }
                echo "<tr>";
            echo "<td>" . stripslashes($row['title']) . "</td>";
            echo "<td>" . stripslashes($row['license']) . "</td>";
            echo "</tr>";
            }
            ?>
        </table>
    <?php

    mysql_close($db);
    ?>
    </body>
</html>