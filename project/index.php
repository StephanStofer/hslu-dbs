<?php
ini_set('display_errors', 1);
error_reporting(-1);
include("connect.php");

$startScriptTime = microtime(TRUE);

// Form Post Daten oder Default Werte
$MESSWERT1_ID = isset($_POST['m1']) 	? $_POST['m1'] 		: 98721425388470291;    // Feinstaub (pm10)
$MESSWERT2_ID = isset($_POST['m2']) 	? $_POST['m2'] 		: 98721425388470297;    // Niederschlag (Niederschlag)
$ORT_ID = 		isset($_POST['loc']) 	? $_POST['loc'] 	: 98721425388470272;    // Bern
$DATUM_FROM = 	isset($_POST['from']) 	? $_POST['from']	: '2017-07-25';         // well...
$DATUM_TO = 	isset($_POST['to']) 	? $_POST['to'] 		: '2017-08-10';
$debug = 		isset($_POST['debug']) 	? $_POST['debug'] 	: false;

$numDays = round((strtotime($DATUM_TO) - strtotime($DATUM_FROM))/(60*60*24),0);

// Dataset
$sqlbase_mw = "SELECT m.datum, kuerzel, einheit, ortschaft, name, round(avg(wert), 2) as wert, round(max(wert), 2) as maxwert, name2, round(avg(wert2), 2) as wert2, round(max(wert2), 2) as maxwert2, einheit2, kuerzel2 
FROM (SELECT datum, wert, ort_id, groesse_id
      FROM messung
      WHERE datum between '$DATUM_FROM' AND '$DATUM_TO'
        and ort_id = $ORT_ID
        and groesse_id = $MESSWERT1_ID) m
         join (select datum,ort_id, wert as wert2, g2.name as name2,g2.einheit as einheit2 , g2.kuerzel as kuerzel2
               from messung
                JOIN groesse g2 ON (g2.id = groesse_id)
               WHERE groesse_id = $MESSWERT2_ID
                ) m2 on (m.datum = m2.datum and m.ort_id = m2.ort_id)
         JOIN ort o
              ON (o.id = m.ort_id)
         JOIN groesse g ON (g.id = m.groesse_id)
		 GROUP BY UNIX_TIMESTAMP(m.datum) DIV ($numDays*720)
		 order by 1";

// connect to DB
$conn = Connection();

// Daten für Dropdown
$ort_liste = mysqli_fetch_all(mysqli_query($conn, "select id, ortschaft from ort order by 2"), MYSQLI_ASSOC);
$messgr_liste = mysqli_fetch_all(mysqli_query($conn, "select id, name, kuerzel, einheit from groesse order by 2"), MYSQLI_ASSOC);

$sm1Time11 = microtime(TRUE);
	$messung = mysqli_fetch_all(mysqli_query($conn, "select datum, wert, maxwert, wert2, maxwert2, name, name2, datum, ortschaft, kuerzel, einheit ,kuerzel2, einheit2 from ($sqlbase_mw) a"), MYSQLI_ASSOC);
$m1Time22 = number_format(microtime(TRUE) - $sm1Time11, 4) . ' Sekunden ';

$rowCount = sizeof($messung);


//grösste Wert (Für Tabelle)
$factor = 1.02;    // +2%
$highest1 = 0;
$highest2 = 0;
foreach ($messung as $b) {
    $ort_name = $b['ortschaft'];
    $messung1_infos = [$b['name'], $b['kuerzel'], $b['einheit']];
    $messung2_infos = [$b['name2'], $b['kuerzel2'], $b['einheit2']];
    if ($b['maxwert'] > $highest1) {
        $highest1 = $b['maxwert'];
    }
    if ($b['maxwert2'] > $highest2) {
        $highest2 = $b['maxwert2'];
    }
}

//Function is used to determine te max value for both y axis (sugestedmax)
function getMaxVal($num) {
	$max05 = array(98721425388470290, 98721425388470293, 98721425388470299); // co, ec, nmvoc
	$max30 = array(98721425388470296, 98721425388470297); // temp, prec

	if (in_array($num, $max05)){
		return 5;
	} elseif (in_array($num, $max30)){
		return 30;
	} else {
		return 80;
	}
	return 0; // failsave
}


// Fixwerte für y achsen
?>

<html>
<head>
    <title>DBS FS20 - Luftqualitätsanalyse</title>
    <script src="charts/Chart.bundle.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        .center {
            text-align: center;
        }

        .from {
            border: 1px solid red;
        }

        .both {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .to {
            border: 1px solid blue;
        }

        debug {
            color: #0099cc;
            font-family: "Lucida Console", Courier, monospace;
            font-size: 14px;
        }
        .debug-container{
            border: 1px solid black;
        }
    </style>
</head>

<body>

<!-- Main container -->
<br>
<div class="container"
     style="max-width: 1200px; border-style: dotted; border-color: <?php echo $debug ? ('#0099cc') : ('#000') ?>">
    <div class="px-5" align="center">

        <div class="w-100 mx-auto px-4">
            <div class="border-bottom">
                <?php if ($debug) echo '<br> 	<debug> - DEBUG MODE ON - </debug>'?>
                <br>
                <h1>Gewählte Daten</h1><br>
            </div>
            <div class="row m-0 w-100">
                <div class="col pt-2">
                    <div class=" border-right">
                        <h4>Messgrösse 1</h4>
                        <?php
                        echo $messung1_infos[0] . ' ' . $messung1_infos[2];
                        ?>
                    </div>
                </div>
                <div class="col pt-2">
                    <div class=" border-right ">
                        <h4>Messstandort und Zeit</h4>
                        Standort: <?php echo $ort_name; ?>
                    </div>

                </div>
                <div class="col pt-2">
                    <div class=" ">
                        <h4>Messgrösse 2</h4>
                        <?php
                        echo $messung2_infos[0] . ' ' . $messung2_infos[2];
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <br>
        <div style="width:100%;">
            <canvas id="canvas"></canvas>
        </div>
        <div class="py-5">
            <form class="form-inline" onsubmit="return validateDate()" method="post">
                <div class="row m-0 w-100">
                    <div class="col from ">
                        <h4>Messgrösse 1</h4>
                        <div class="form-group">
                            <label class="" for="m1">Erste Messgrösse wählen:</label>
                            <select class="custom-select my-1 mr-sm-2" id="m1"
                                    name="m1"
                                    required>
                                <option disabled selected>Bitte wählen...</option>
								<?php foreach ($messgr_liste as $o) { echo '<option value=' . $o['id'];
									if ($_POST['m1'] == $o['id']) echo ' selected="selected"';
									echo '>' . $o['name'] . ' ' . $o['kuerzel'] . '</option>';}?>
                            </select>
                        </div>
                        <input type="hidden" name="m1Holder" id="m1Holder">
                    </div>
                    <div class="col both">
                        <h4>Messstandort und Zeit</h4>
                        <div class="form-group">
                            <label for="loc">Ortschaft wählen:</label>
                            <select class="custom-select w-100 my-1 mr-sm-2" id="loc"
                                    name="loc"
                                    required>
                                <option disabled selected>Bitte wählen...</option>
								<?php foreach ($ort_liste as $o) { echo '<option value=' . $o['id'];
									if ($_POST['loc'] == $o['id']) echo ' selected="selected"';
								echo '>' . $o['ortschaft'] . '</option>';}?>
                            </select>
                        </div>
                        <input type="hidden" name="locHolder" id="locHolder">
                        <div class="form-group">
                            <label for="from">Von: </label>
                            <input id="from" class="w-100" name="from" type="date" min="2000-01-01"
                                <?php echo 'value=' . $DATUM_FROM; ?>
                                   max="2019-12-31">
                        </div>
                        <div class="form-group pt-2">
                            <label for="to">Bis: </label>
                            <input id="to" name="to" type="date" class="w-100" min="2000-01-01"
                                <?php echo 'value=' . $DATUM_TO; ?>
                                   max="2019-12-31">
                        </div><br>
                    </div>
                    <div class="col to">
                        <h4>Messgrösse 2</h4>
                        <div class="form-group">
                            <label class="" for="m2">Zweite Messgrösse wählen:</label>
                            <select class="custom-select my-1 mr-sm-2" id="m2"
                                    name="m2"
                                    required>
                                <option disabled selected>Bitte wählen...</option>
                                <?php foreach ($messgr_liste as $o) { echo '<option value=' . $o['id'];
									if ($_POST['m2'] == $o['id']) echo ' selected="selected"';
									echo '>' . $o['name'] . ' ' . $o['kuerzel'] . '</option>';}?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="w-100">
					<div class="float-right py-2 mx-3">
                       <input type="checkbox" class="form-check-input" name="debug" value="true" <?php if($debug) echo 'checked'?>>
						<label class="form-check-label" for="debug">debug</label>
                    </div>
                    <div class="float-right py-2 mx-3">
                        <?php if ($debug) echo '<debug> ' . $numDays . ' Tage - ' . $rowCount . ' Rows - ' .
                            number_format(microtime(TRUE) - $startScriptTime, 4) . ' Sekunden ' ?>
                        <button type="submit" name="sendData" class="btn btn-primary">Submit</button>
                    </div>
                </div>     
            </form>
            <?php if ($debug) echo'<div class="w-100 debug-container"><br>'. '<debug> ' . $sqlbase_mw . ' <br><br>Dauer: ' . $m1Time22 . '</debug></div>'; ?>
        </div>
    </div>
</div>
<script>
    var dates = {
        convert: function (d) {
            return (
                d.constructor === Date ? d :
                    d.constructor === Array ? new Date(d[0], d[1], d[2]) :
                        d.constructor === Number ? new Date(d) :
                            d.constructor === String ? new Date(d) :
                                typeof d === "object" ? new Date(d.year, d.month, d.date) :
                                    NaN
            );
        },
        compare: function (a, b) {
            //  -1 : if a < b
            //   0 : if a = b
            //   1 : if a > b
            // NaN : if a or b is an illegal date
            return (
                isFinite(a = this.convert(a).valueOf()) &&
                isFinite(b = this.convert(b).valueOf()) ?
                    (a > b) - (a < b) :
                    NaN
            );
        },
        inRange: function datediff(days, first, second) {
            console.log(Math.round((second - first) / (1000 * 60 * 60 * 24)))
            return Math.round((second - first) / (1000 * 60 * 60 * 24)) > days ? false : true;
        }
    }

    // Inputdata Validation
    function validateDate() {
        let date_from = new Date(document.getElementById("from").value);
        let date_to = new Date(document.getElementById("to").value);
        if (dates.compare(date_from, date_to) === 1) {
            alert("Von Datum Kleiner als Bis Datum");
            return false;
        } else if (!dates.inRange(380, date_from, date_to)) {
            alert("Mehr als 90 Tage abstand!");
            return false;
        }
        return true;
    }

    // Graph Configuration
    var config = {
        type: 'line',
        data: {
            labels: [<?php foreach ($messung as $b) { echo '"' . $b['datum'] . '",';}?>],
            datasets: [
			{
                label: "<?php echo $messung1_infos[0]; if ($numDays>5) echo ' max';?>",
                data: [<?php foreach ($messung as $b) {
                    echo '"' . $b['maxwert'] . '",';
                }?>],
                fill: true,
                backgroundColor: 'rgba(230, 0, 0, 0.1)',
                borderColor: 'rgba(230, 0, 0, 1.0)',
                borderWidth: 2,
                pointBorderWidth: 0.2,
                yAxisID: "y-axis-1",
            }, <?php if ($numDays>5) { echo '{
				label: "' . $messung1_infos[0] . ' avg",
                data: ['; foreach ($messung as $b) { echo '"' . $b['wert'] . '",';};
				echo '],
                fill: false,
                backgroundColor: \'rgba(230, 0, 0, 0.1)\',
                borderColor: \'rgba(230, 0, 0, 1.0)\',
                borderWidth: 2,
                pointBorderWidth: 0.2,
                background: false,	
                yAxisID: \'y-axis-1\',
				borderDash: [2, 2],
				hidden: true,
            },';}?>
			{
                label: "<?php echo $messung2_infos[0]; if ($numDays>5) echo ' max';?>",
                data: [<?php foreach ($messung as $b) {
                    echo '"' . $b['maxwert2'] . '",';
                }?>],
                fill: true,
                backgroundColor: 'rgba(0, 0, 204, 0.1)',
                borderColor: 'rgba(0, 0, 204, 1.0)',
                borderWidth: 2,
                pointBorderWidth: 0.2,
                yAxisID: "y-axis-2",
            }<?php if ($numDays>5) { echo ',{
				label: "' . $messung2_infos[0] . ' avg",
                data: ['; foreach ($messung as $b) { echo '"' . $b['wert2'] . '",';};
				echo '],
                fill: false,
                backgroundColor: \'rgba(0, 0, 204, 0.1)\',
                borderColor: \'rgba(0, 0, 204, 1.0)\',
                borderWidth: 2,
                pointBorderWidth: 0.2,
                background: false,
                yAxisID: \'y-axis-2\',
				borderDash: [2, 2],
				hidden: true,
            }';}?>]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },
            hover: {
                mode: 'label'
            },
            scales: {
                xAxes: [{
                    display: true, gridLines: {
                        offsetGridLines: false
                    },
                }],
                yAxes: [{
                    display: true,
                    id: "y-axis-1",
                    position: "left",
                    scaleLabel: {
                        display: true,
                        labelString: "<?php echo $messung1_infos[0] . ' (' . $messung1_infos[1] . ') ' . $messung1_infos[2]?>"
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: '<?php echo getMaxVal($MESSWERT1_ID);?>',
                    }
                }, {
                    display: true,
                    id: "y-axis-2",
                    position: "right",
                    scaleLabel: {
                        display: true,
                        labelString: "<?php echo $messung2_infos[0] . ' (' . $messung2_infos[1] . ') ' . $messung2_infos[2]?>"
                    }, gridLines: {
                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: '<?php echo getMaxVal($MESSWERT2_ID);?>',
                    }
                }]
            },
            title: {
                display: true,
                text: 'Vergleich <?php echo $messung1_infos[0] . ' und ' . $messung2_infos[0]?>'
            }
        }
    };

    window.onload = function () {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx, config);
    };

</script>
</body>
</html>
