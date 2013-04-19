<html>
<head>
<title>Show Actor Information</title>
</head>
<body bgcolor="#B9F18F">




<?php

$db_connection = mysql_connect("localhost", "cs143", "");
if (!$db_connection)
{
    $errmsg = mysql_error($db_connection);
    print "Connection to mysql server failed: $errmsg <br />";
    exit(1);
}


//now connected, then enter database
mysql_select_db("CS143", $db_connection);

$qInput = "SELECT * 
           FROM Actor 
           ORDER by last;";


$result = mysql_query($qInput, $db_connection);

//search query error
if (!$result){
    exit(1);
}

echo "<FORM ACTION=\"showActInfo.php\" METHOD=\"GET\">

<p>Select Actor/Actress Information:

<SELECT NAME=\"dropdown\" VALUE=\"options\">
<OPTION VALUE=\"\"></OPTION>";


while($row = mysql_fetch_row($result))
{
    echo "<OPTION VALUE=$row[0] >$row[1], $row[2]</OPTION>";
}
echo "</SELECT></p>
    <INPUT TYPE=\"submit\" VALUE=\"Search\">";
echo "</FORM>";
echo "<hr size=4 width=95%>";

//capture passed variables
if ($_GET["aid"]=="")
    $actid=$_GET["dropdown"];//get id of actor
else
    $actid=$_GET["aid"];//passed variable by url

//query actor info
$query2="SELECT *
         FROM Actor
         WHERE id=$actid;";
$actResult = mysql_query($query2, $db_connection);
//search query error (ie. stop query when user hasn't even set input)
if (!$actResult){
    exit(1);
}

$actRow = mysql_fetch_row($actResult);
echo "<p style=\"font-family: Arial\">
      <h2 style=\"font-family: Verdana\">
        --Actor/Actress Info--
      </h2>
      <b>Name:</b> $actRow[2] $actRow[1]<br>
      <b>Gender:</b> $actRow[3]<br>
      <b>Born:</b> $actRow[4]<br>
      <b>Death:</b> $actRow[5]</p>";

//get movie info from actor i
$query3="SELECT year,title,role,mid
         FROM MovieActor,Movie
         WHERE aid=$actid AND mid=Movie.id
         ORDER BY year;";
$movResult = mysql_query($query3, $db_connection);

if (!$movResult){
    echo "<br> Query Error <br>";
    exit(1);
}
echo "<h2 style=\"font-family: Verdana\">--Filmography--</h2>"; 

//make table
echo "<table style=\"font-family: Arial\" border='1'width=\"800\"><tr align='center'>";
//table headers
echo "<th>Year</th>";
echo "<th>Title</th>";
echo "<th>Role</th>";
echo "</tr>\n";

//now get the tuples into the table
while($movRow = mysql_fetch_row($movResult))
{
    //output each row onto the table
    echo "<tr align='center'>";
    //loop throw each tuple in the fetched result 
    for ($i=0; $i<=2; $i++)
    {
        if ($i==1)
        {
            echo "<td>
                <a href=\"./showMovInfo.php?mid=$movRow[3]\" target=\"Main\">
                $movRow[1]</a></td>";
        }
        else
            echo "<td>$movRow[$i]</td>";
    }
    echo "</tr>\n";
}


mysql_close($db_connection);
?>

</body>
</html>
