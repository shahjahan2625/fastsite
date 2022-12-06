<html>
<head>
<style>

h1 {color:#0000ff;}

body
table, td, th
{
border:1px solid green;
padding:0 5px;
}
th
{
background-color:green;
color:white;
}
{
background-color:#e0ffff;
}
</style>
<title>Usage</title>
</head>
<body>
<center>
<h1>Usage Details</h1>

<?php
//phpinfo();
$now_date=date("Y-m-d H:i:s"); ;
$now_date=date("m"); ;
//print_r($now_date);
$first_day_this_month=date('Y-m-01 00:00:00');
$last_day_this_month=date('Y-m-t 23:59:59');
//print_r($first_day_this_month);
//print_r($last_day_this_month);
$con=mysqli_connect("localhost","root","","");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$query="select  src_info.firstname,src_info.lastname,src_info.cid,src_info.phone, src_info.credit, ifnull(call_info.total_bill,0)as total_bill from (select cc_card.firstname, cc_card.lastname, cc_callerid.cid, cc_card.phone, cc_card.credit from cc_card inner join cc_callerid on cc_card.id=cc_callerid.id_cc_card)src_info left join (select src,sum(sessionbill)as total_bill from cc_call where starttime  between '$first_day_this_month' and '$last_day_this_month'    group by src)call_info on src_info.cid=call_info.src order by cid  asc";
//echo $query;
$result = mysqli_query($con,$query);

echo "<table border='2'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Caller ID</th>
<th>Phone</th>
<th>Credit</th>
<th>Usage</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['firstname'] . "</td>";
  echo "<td>" . $row['lastname'] . "</td>";
  echo "<td>" . $row['cid'] . "</td>";
  echo "<td>" . $row['phone'] . "</td>";
	/*$roundedUp=round( $item['bill_amount'], 3, PHP_ROUND_HALF_UP);
	//$roundedDown=round( $item->BillAmount, 3, PHP_ROUND_HALF_DOWN);
	//$item->BillAmount = number_format($roundedUp, 3, '.', ','); //$number,numbersAfterDecimal,decimal separator, thousand separator
	echo number_format($roundedUp, 3, '.', ',');*/
  //$roundedUpCredit=round( $row['credit'], 3, PHP_ROUND_HALF_UP);
  echo "<td>" . number_format($row['credit'], 3, '.', ',') . "</td>";
  echo "<td>" . number_format($row['total_bill'], 3, '.', ',') . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_close($con);

?> 
</center>
</body>
</html>