<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <body>
    <?php
    $scriptName = "PutComment.php";
    include("PHPprinter.php");
    $startTime = getMicroTime();
    
	$to = NULL;
	if (isset($_POST['to']))
	{
    	$to = $_POST['to'];
	}
	else if (isset($_GET['to']))
	{
    	$to = $_GET['to'];
	}
    else
    {
        printError($scriptName, $startTime, "PutComment", "You must provide a user identifier!<br>");
        exit();
    }      

	$nickname = NULL;
	if (isset($_POST['nickname']))
	{
    	$nickname = $_POST['nickname'];
	}
	else if (isset($_GET['nickname']))
	{
    	$nickname = $_GET['nickname'];
	}
	else
	{
		printError($scriptName, $startTime, "PutComment", "You must provide a nick name!<br>");
		exit();
	}
	$password = NULL;
	if (isset($_POST['password']))
	{
    	$password = $_POST['password'];
	}
	else if (isset($_GET['password']))
	{
    	$password = $_GET['password'];
	}
	else
	{
		printError($scriptName, $startTime, "PutComment", "You must provide a password!<br>");
		exit();
	}
	$itemId = NULL;
	if (isset($_POST['itemId']))
	{
    	$itemId = $_POST['itemId'];
	}
	else if (isset($_GET['itemId']))
	{
    	$itemId = $_GET['itemId'];
	}
	else
	{
		printError($scriptName, $startTime, "PutComment", "You must provide an item identifier!<br>");
		exit();
	}

    getDatabaseLink($link);

    begin($link);
    // Authenticate the user
    $userId = authenticate($nickname, $password, $link);
    if ($userId == -1)
    {
      printError($scriptName, $startTime, "PutComment", "You don't have an account on RUBiS!<br>You have to register first.<br>\n");
      commit($link);
      exit();	
    }

    $result = mysql_query("SELECT * FROM items WHERE items.id=$itemId");
	if (!$result)
	{
		error_log("[".__FILE__."] Query 'SELECT * FROM items WHERE items.id=$itemId' failed: " . mysql_error($link));
		die("ERROR: Item query failed for item '$itemId': " . mysql_error($link));
	}
    if (mysql_num_rows($result) == 0)
    {
      printError($scriptName, $startTime, "PutComment", "<h3>Sorry, but this item does not exist.</h3><br>");
      commit($link);
      exit();
    }

    $toRes = mysql_query("SELECT * FROM users WHERE id=\"$to\"");
	if (!$toRes)
	{
		error_log("[".__FILE__."] Query 'SELECT * FROM users WHERE id=\"$to\"' failed: " . mysql_error($link));
		die("ERROR: User query failed for user '$to': " . mysql_error($link));
	}
    if (mysql_num_rows($toRes) == 0)
    {
      printError($scriptName, $startTime, "PutComment", "<h3>Sorry, but this user does not exist.</h3><br>");
      commit($link);
      exit();
    }

    $row = mysql_fetch_array($result);
    $userRow = mysql_fetch_array($toRes);

    printHTMLheader("RUBiS: Comment service");

    print("<center><h2>Give feedback about your experience with ".$row["name"]."</h2><br>\n");
    print("<form action=\"/PHP/StoreComment.php\" method=POST>\n".
          "<input type=hidden name=to value=$to>\n".
          "<input type=hidden name=from value=$userId>\n".
          "<input type=hidden name=itemId value=$itemId>\n".
          "<center><table>\n".
          "<tr><td><b>From</b><td>$nickname\n".
          "<tr><td><b>To</b><td>".$userRow["nickname"]."\n".
          "<tr><td><b>About item</b><td>".$row["name"]."\n".
          "<tr><td><b>Rating</b>\n".
          "<td><SELECT name=rating>\n".
          "<OPTION value=\"5\">Excellent</OPTION>\n".
          "<OPTION value=\"3\">Average</OPTION>\n".
          "<OPTION selected value=\"0\">Neutral</OPTION>\n".
          "<OPTION value=\"-3\">Below average</OPTION>\n".
          "<OPTION value=\"-5\">Bad</OPTION>\n".
          "</SELECT></table><p><br>\n".
          "<TEXTAREA rows=\"20\" cols=\"80\" name=\"comment\">Write your comment here</TEXTAREA><br><p>\n".
          "<input type=submit value=\"Post this comment now!\"></center><p>\n");

    mysql_free_result($result);
    commit($link);
    mysql_close($link);
    
    printHTMLfooter($scriptName, $startTime);
    ?>
  </body>
</html>
