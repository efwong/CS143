<html>
<head>
<title>Search Page</title>
</head>
<body bgcolor="#B9F18F">

<font style="font-family:Arial">
Enter the name of the actor or movie that you want to search for.
</font>
<FORM ACTION="search.php" METHOD="GET">
<p style="font-family: Arial">
<b>Search:</b>
<INPUT TYPE="text" NAME="textbox" SIZE="20" MAXLENGTH=20>
<INPUT TYPE="submit" VALUE="Submit">
</p>
</FORM>

<hr size=4 width=95%>

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



$textIn=$_GET["textbox"];
$sanText=mysql_real_escape_string($textIn, $db_connection);
$splitIn=preg_split('/[\s \.\,\'\"]/' ,$sanText);//split string by regex

//check blank entry
if ($textIn=="")
    exit(1);
//search actors
$queryA="SELECT * 
         FROM Actor
         WHERE last LIKE \"%$splitIn[0]%\" AND first LIKE \"%$splitIn[1]%\"
            OR (last LIKE \"%$splitIn[1]%\" AND first LIKE \"%$splitIn[0]%\");";

$result = mysql_query($queryA, $db_connection);
if (!$result){
    echo "<br> Query Error <br>";
    exit(1);
}
echo "<br><p style=\"font-family: Arial\">
      <b>Searching for matching actors/actresses...</b><br>";

while($row = mysql_fetch_row($result))
{
    echo "Actor: <a href=\"./showActInfo.php?aid=$row[0]\" target=\"Main\">
        $row[2] $row[1]($row[4])</a><br>";
}

//search movies
$queryM="Select id,title,year
         FROM Movie
         WHERE title LIKE \"%$sanText%\";";
$movResult=mysql_query($queryM, $db_connection);
echo "<br><b>Searching for matching movies...</b><br>";
while($row = mysql_fetch_row($movResult))
{
    echo "Movie: <a href=\"./showMovInfo.php?mid=$row[0]\" target=\"Main\">
        $row[1]($row[2])</a><br>";
}
echo "</p>";
?>
</body>
</html>
