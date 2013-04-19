<html>
<head>
<title>Show Movie Information</title>
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

$qInput = "SELECT id,title,year 
            FROM Movie
            ORDER by title;";


$result = mysql_query($qInput, $db_connection);

//search query error
if (!$result){
    exit(1);
}

echo "<FORM ACTION=\"showMovInfo.php\" METHOD=\"GET\">

<p>See Movie Information:

<SELECT NAME=\"dropdown\" VALUE=\"options\">
<OPTION VALUE=\"\"></OPTION>";

while($row = mysql_fetch_row($result))
{
    echo "<OPTION VALUE=$row[0] >$row[1]($row[2])</OPTION>";
}
echo "</SELECT></p>
    <INPUT TYPE=\"submit\" VALUE=\"Search\">";
echo "</FORM>";
echo "<hr size=4 width=95%>";

//~~~~~~~~~~~~~~~~~~Begins of locating the user's choice
if ($_GET["mid"]=="")
    $movid=$_GET["dropdown"];//get id of actor
else
    $movid=$_GET["mid"];//passed variable by url

//get movie info
$query2="SELECT *
         FROM Movie
         WHERE id=$movid;";
$movResult = mysql_query($query2, $db_connection);

//catch empty drop down menu
if(!$movResult)
    exit(1);

$movRow = mysql_fetch_row($movResult);

//get director info
$query3="SELECT last,first,dob FROM MovieDirector,Director
         WHERE mid=$movRow[0] AND did=Director.id;";
$dirResult = mysql_query($query3, $db_connection);
if (!$dirResult){
    echo "<br> Query Error <br>";
    exit(1);
}
$dirRow = mysql_fetch_row($dirResult);
//get genre
$query4="SELECT genre FROM MovieGenre WHERE mid=$movRow[0];";
$genResult = mysql_query($query4, $db_connection);

//search query error (ie. stop query when user hasn't even set input)
if (!$genResult){
    echo "<br> Query Error <br>";
    exit(1);
}
$genRow = mysql_fetch_row($genResult);
echo "<p style=\"font-family: Arial\">
      <h2 style=\"font-family: Verdana\">
        --Movie Info--
      </h2>
      <b>Title:</b> $movRow[1]<br>
      <b>Release Year:</b> $movRow[2]<br>
      <b>Production Company:</b> $movRow[4]<br>
      <b>Director:</b>";
if ($dirRow[0]!="")
    echo " $dirRow[1] $dirRow[0] ($dirRow[2])";

echo "<br><b>MPAA Rating:</b> $movRow[3]<br>
      <b>Genre:</b> $genRow[0]
      </p>";

$query5="SELECT aid,last,first,role
         FROM MovieActor,Actor
         WHERE mid=$movRow[0] AND aid=Actor.id;";
$actResult= mysql_query($query5, $db_connection);
echo "<p style=\"font-family: Arial\">
      <h2 style=\"font-family: Verdana\">
      --Cast--
      </h2>";

while($actRow = mysql_fetch_row($actResult))
{
    echo "<pre style=\"font-family: Arial\">";
    echo "<a href=\"./showActInfo.php?aid=$actRow[0]\" target=\"Main\">$actRow[2] $actRow[1]</a>";
    echo "    as   ...   \"$actRow[3]\"<br></pre>";
}
echo "</p>";

//~~~~~~~~~~~~~~Show comments begin here
$query6="SELECT *
         FROM Review
         WHERE mid=$movid;";
$movComment = mysql_query($query6, $db_connection);
//search query error (ie. stop query when errors occurs)

$query7="SELECT AVG(rating),COUNT(mid)
	 FROM Review
	 WHERE mid=$movid;";
$movAvgScore = mysql_query($query7, $db_connection);
//search query error (ie. stop query when errors occurs)
if (!$movAvgScore | !$movComment){
    echo "<p> Review Query Error</p>";
    exit(1);
}

$movieScore=mysql_fetch_row($movAvgScore);
echo "<h2 style=\"font-family: Verdana\">
      --Review/Comments-- </h2>";
echo "<p style=\"font-family: Arial\" size=5>";
//when Amir is done change the php location
echo "<a href=\"./comments.php?mymid=$movid\" target=\"Main\">
      <b>Please rate the movie!</b></a><br>";
//check for no comments/reviews
$numComments=mysql_num_rows($movComment);
if ($numComments==0){//there always must be a mid o/w no reviews
    echo "<p>There are no user submitted Reviews for 
        <b><i>$movRow[1]</i></b>.</p>";
    exit(1);
}
echo "<FONT COLOR=\"#FF0000\"><b>Average Rating: </b></FONT> 
      <FONT SIZE=5><b>$movieScore[0]</b></FONT> out of 5 from $movieScore[1] review(s).<br><br>";

while ($movCommentRow = mysql_fetch_row($movComment)){
	echo "Date: $movCommentRow[1]<br>
           User:
           <FONT COLOR=\"#0000FF\"> $movCommentRow[0] </FONT> 
           gave the movie a rating of 
           <FONT COLOR=\"#FF00FF\"> <b>$movCommentRow[3] / 5.0</b> </FONT><br>
           <b><i>comment:</i></b>
	       $movCommentRow[4]<br><br>";
}
echo "</p>";

mysql_close($db_connection);
?>

</body>
</html>
