<?php 

$filepath = realpath (dirname(__FILE__));
require_once($filepath."/api/dbconfig.php");

$num_days = 03;
date_default_timezone_set('Europe/Istanbul');
$connect = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
$query = "SELECT * FROM " .DB_TABLE. "";
$result = mysqli_query($connect, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))
{
	$end_date = date("Y-m-d H:i:s", strtotime("+" . $num_days . "hours", strtotime($row["timestamp"]))); //DATE MODIFICATION DUE TO RIGHT TIMEZONE
 	$chart_data .= "{ timestamp:'".$end_date."', tempin:".$row["tempin"].", tempout:".$row["tempout"].", hum:".$row["hum"]."}, "; //GRAPH VALUE INITIALIZATION
}
$chart_data = substr($chart_data, 0, -2);


?>


<DOCTYPE! html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> Temperature and Humidity Sensor</title>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
		<style>
			
			body { background-color: #FFFFFF;}
			table{ border-collapse:collapse;}
			td{ text-align: center; }
			button{border-radius: 8px; padding: 12px 28px; font-size: 16px;}
			.headers{ color:#000000; }
			.buttons{margin-right:15px; margin-left:15px; }
			.button:hover { background-color: #4CAF50; color: white;}
			.graph-header{ text-align:center; }
			img{width:80px; height:80px; }
			th{text-align:center;}
			</style>

	</head>

	<body >
		<p>
			<h1 class="headers" align = center>TEMPLOGGER</h1>
			<h1 class="headers" align = center>PLACEHOLDERPLACEHOLDER</h2>
			</br>
		</p>
		<table align="center" style="width:70%">
			<tr >
				<?php include 'api/now.php'; ?>
			</tr>
			<tr align="center" style="text-align:center;">
				<th class="graph-header" align="center" style="text-align:center;"><h1><center>GRAPHTITLEGRAPHTITLE</center></h1></th>
			</tr>
			<tr>
				<td class="linegraph"> <div id="chart"></div> </td>
			</tr>
		</table>
		<table align="center">	
			<tr "width:50px;">
				<td class="buttons" style="padding:70px;"><a href="/api/daily_index.php"><button>DAILY VALUES</button></a></td>
				<td class="buttons" style="padding:70px;" ><a href="/api/all_index.php"><button>ALL VALUES</button></a></td>
			</tr>
			
		</table>
		
	</body>
    <!--
		GRAPHICS SCRIPT
	 -->
    <script>
		Morris.Line({
		    element : 'chart',
		    data:[<?php echo $chart_data; ?>],
		    xkey:'timestamp',
		    ykeys:['tempout', 'tempin', 'hum'],
		    labels:['LABEL1', 'LABEL2', 'LABEL3'],
			lineColors:['#E95624' , '#1A64E7' , '#1ADC7B' ],
		    hideHover:'auto',
			parseTime:true,
		    stacked:true
		});
	</script>
</html>
