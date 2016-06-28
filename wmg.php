<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
// we connect to example.com and port 3307
$link = mysql_connect('localhost', 'crm', 'crm14');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';

mysql_select_db('crm');

$q = "SELECT *, contact.id as cid FROM  contact, address, appointment
WHERE contact.address_id = address.id AND address.lead_type = 'CHERUB_M' AND contact.role = 'CHILD' 
AND contact.dob IN(SELECT max(contact.dob) FROM contact GROUP BY contact.address_id) AND appointment.address_id = address.id GROUP BY address.id"; 

$result = mysql_query($q);
if (!$result) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $q;
    die($message);
}
?>
<h3>Rows: <?php echo mysql_num_rows($result);?></h3>
<table width="200" border="1">
  <tr>
    <th scope="col">firstname</th>
    <th scope="col">surname</th>
    <th scope="col">dob</th>
    <th scope="col">sex</th>
    <th scope="col">role</th>
    <th scope="col">wmg_cherub</th>
  </tr>

<?php
while ($row = mysql_fetch_object($result)) {
?>
  <tr>
    <td scope="col"><?php echo $row->firstname; ?></td>
	<td scope="col"><?php echo $row->surname; ?></td>
    <td scope="col"><?php echo $row->dob; ?></td>
    <td scope="col"><?php echo $row->sex; ?></td>
    <td scope="col"><?php echo $row->role; ?></td>
    <td scope="col"><?php echo $row->wmg_cherub; ?></td>
  </tr>
 
 <?php
 $q = "UPDATE contact SET wmg_cherub = 1 WHERE contact.id = ".$row->cid;
 $update = mysql_query($q);
 if (!$update) {
	$message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $q;
    die($message); 
 }
 ?> 
  
 <?php } ?> 
  
  
</table>

<?php mysql_free_result($result); ?>  
<?php mysql_close($link);?>

</body>
</html>
