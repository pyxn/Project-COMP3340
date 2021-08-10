<?php

session_start();

require_once('./helpers/ThemeHelper.php');
$theme_color = 'blue';
if (isset($_SESSION['theme'])) {
    $theme_color = $_SESSION['theme'];
}

?>

<html>

<head>
    <title>Find Dream City</title>
    <meta name="author" content="co-authored by Weichong Wu, Yijiu Xu, Pao Yu, Chen Qiao">
    <meta name="keywords" content="new city, better life, filters, Canadian cities, livable places">
    <meta name="description" content="This website contains filters and a table dispalying the cities after filtration.">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
    <?php echo ThemeHelper::get_css_theme($theme_color); ?>
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <h3 style="color: #fff;">Find Dream City
                <a class="btn btn-primary" href="index.php" role="button" style="float: right; color: black; background-color: white;">Home</a>
            </h3>
        </div>
    </nav>
    <div class="container">
        <h3 style="text-align: center; font-weight: bold;">FILTERS</h3>
        <hr>
        <div class="row">
            <form class="form-horizontal" action="dreamcity.php" method="POST">
                <div class="form-group">
                    <label class="col-lg-2 control-label">province</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="province">
                            <option value="">Click to select</option>
                            <option value="AB">Alberta</option>
                            <option value="BC">British Columbia</option>
                            <option value="MB">Manitoba</option>
                            <option value="NB">New Brunswick</option>
                            <option value="NL">Newfoundland and Labrador</option>
                            <option value="NS">Nova Scotia</option>
                            <option value="ON">Ontario</option>
                            <option value="PE">Prince Edward Island</option>
                            <option value="QC">Quebec</option>
                            <option value="SK">Saskatchewan</option>
                            <option value="NW">Northwest Territories</option>
                            <option value="NU">Nunavut</option>
                            <option value="YK">Yukon</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Scenery Rating</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="rating">
                            <option value="">Click to select</option>
                            <option value="1">☆ and above</option>
                            <option value="2">☆☆ and above</option>
                            <option value="3">☆☆☆ and above</option>
                            <option value="4">☆☆☆☆ and above</option>
                            <option value="5">☆☆☆☆☆</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Min Population</label>
                    <div class="col-lg-4">
                        <input type="number" min=920 max=6555205 name="from_pop" class="form-control" placeholder="920 - 6555205">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Max Population</label>
                    <div class="col-lg-4">
                        <input type="number" min=920 max=6555205 name="to_pop" class="form-control" placeholder="920 - 6555205">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Min Avg Home Price</label>
                    <div class="col-lg-4">
                        <input type="number" min=101213 max=2100000 name="from_price" class="form-control" placeholder="101213 - 2100000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Max Avg Home Price</label>
                    <div class="col-lg-4">
                        <input type="number" min=101213 max=2100000 name="to_price" class="form-control" placeholder="101213 - 2100000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Lowest Min Income</label>
                    <div class="col-lg-4">
                        <input type="number" min=32328 max=287597 name="from_income" class="form-control" placeholder="32328 - 287597">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Highest Min Income</label>
                    <div class="col-lg-4">
                        <input type="number" min=32328 max=287597 name="to_income" class="form-control" placeholder="32328 - 287597">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-4">
                        <input type="submit" class="btn btn-primary" name="submit" id="submit">
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>City/Town</th>
                        <th>Province</th>
                        <th>Population</th>
                        <th>Avg Home Price</th>
                        <th>Min Income Required</th>
                        <th>Scenery Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = mysqli_connect('localhost', 'qiao6', 'Woshishen@2021');
                    if (!$conn) {
                        die("connection fail: " . mysqli_connect_error());
                    }

                    mysqli_select_db($conn, 'qiao6_comp3340');

                    if (isset($_POST["submit"])) {
                        $province = $_POST["province"];
                        $rating = $_POST["rating"];
                        $from_pop = $_POST["from_pop"];
                        $to_pop = $_POST["to_pop"];
                        $from_price = $_POST["from_price"];
                        $to_price = $_POST["to_price"];
                        $from_income = $_POST["from_income"];
                        $to_income = $_POST["to_income"];

                        if ($province != "" || $rating != "" || $from_pop != "" || $to_pop != "" || $from_price != "" || $to_price != "" || $from_income != "" || $to_income != "") {
                            $query = "SELECT * from cities WHERE";
                            if ($province != "") {
                                $query = $query . " province='$province'";
                            }
                            if ($rating != "") {
                                if ($province != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " scenery_rating>=$rating";
                            }
                            if ($from_pop != "") {
                                if ($province != "" || $rating != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " population>=$from_pop";
                            }
                            if ($to_pop != "") {
                                if ($province != "" || $rating != "" || $from_pop != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " population<=$to_pop";
                            }
                            if ($from_price != "") {
                                if ($province != "" || $rating != "" || $from_pop != "" || $to_pop != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " avg_home_price_2020>=$from_price";
                            }
                            if ($to_price != "") {
                                if ($province != "" || $rating != "" || $from_pop != "" || $to_pop != "" || $from_price != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " avg_home_price_2020<=$to_price";
                            }
                            if ($from_income != "") {
                                if ($province != "" || $rating != "" || $from_pop != "" || $to_pop != "" || $from_price != "" || $to_price != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " min_income_required_20_down>=$from_income";
                            }
                            if ($to_income != "") {
                                if ($province != "" || $rating != "" || $from_pop != "" || $to_pop != "" || $from_price != "" || $to_price != "" || $from_income != "") {
                                    $query = $query . " AND ";
                                }
                                $query = $query . " min_income_required_20_down<=$to_income";
                            }

                            $data = mysqli_query($conn, $query);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row = mysqli_fetch_assoc($data)) {
                                    $rank = $row["rank"];
                                    $city = $row["city_town"];
                                    $province = $row["province"];
                                    $pop = $row["population"];
                                    $avg_price = $row["avg_home_price_2020"];
                                    $min_income = $row["min_income_required_20_down"];
                                    $rating = $row["scenery_rating"];

                                    echo "<tr onclick=\"window.location='city.php?rk=$row[rank]'\" >";
                    ?>
                                    <td><?php echo $rank; ?></td>
                                    <td><?php echo $city; ?></td>
                                    <td><?php echo $province; ?></td>
                                    <td><?php echo $pop; ?></td>
                                    <td>$<?php echo $avg_price; ?></td>
                                    <td>$<?php echo $min_income; ?></td>
                                    <td><?php for ($i = 0; $i < $rating; $i++) {
                                            echo "☆";
                                        } ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">Records not found.</td>
                                </tr>

                    <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </div>

    <footer>
        <?php echo ThemeHelper::get_theme_switcher($theme_color); ?>
    </footer>
</body>

</html>
