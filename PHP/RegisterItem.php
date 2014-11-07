<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <body>
    <?php
    $scriptName = "RegisterItem.php";
    include("PHPprinter.php");
    $startTime = getMicroTime();
    
    $userId = NULL;
    if (isset($_POST['userId']))
    {
    	$userId = $_POST['userId'];
    }
    else if (isset($_GET['userId']))
    {
    	$userId = $_GET['userId'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide a user identifier!<br></h3>");
    	exit();
    }
    $categoryId = NULL;
    if (isset($_POST['categoryId']))
    {
    	$categoryId = $_POST['categoryId'];
    }
    else if (isset($_GET['categoryId']))
    {
    	$categoryId = $_GET['categoryId'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide a category identifier !<br></h3>");
    	exit();
    }
    $name = NULL;
    if (isset($_POST['name']))
    {
    	$name = $_POST['name'];
    }
    else if (isset($_GET['name']))
    {
    	$name = $_GET['name'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide an item name !<br></h3>");
    	exit();
    }
    $initialPrice = NULL;
    if (isset($_POST['initialPrice']))
    {
    	$initialPrice = $_POST['initialPrice'];
    }
    else if (isset($_GET['initialPrice']))
    {
    	$initialPrice = $_GET['initialPrice'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide an initial price !<br></h3>");
    	exit();
    }
    $reservePrice = NULL;
    if (isset($_POST['reservePrice']))
    {
    	$reservePrice = $_POST['reservePrice'];
    }
    else if (isset($_GET['reservePrice']))
    {
    	$reservePrice = $_GET['reservePrice'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide a reserve price !<br></h3>");
    	exit();
    }
    $buyNow = NULL;
    if (isset($_POST['buyNow']))
    {
    	$buyNow = $_POST['buyNow'];
    }
    else if (isset($_GET['buyNow']))
    {
    	$buyNow = $_GET['buyNow'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide a Buy Now price !<br></h3>");
    	exit();
    }
    $duration = NULL;
    if (isset($_POST['duration']))
    {
    	$duration = $_POST['duration'];
    }
    else if (isset($_GET['duration']))
    {
    	$duration = $_GET['duration'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide a duration !<br></h3>");
    	exit();
    }
    $qty = NULL;
    if (isset($_POST['quantity']))
    {
    	$qty = $_POST['quantity'];
    }
    else if (isset($_GET['quantity']))
    {
    	$qty = $_GET['quantity'];
    }
    else
    {
    	printError($scriptName, $startTime, "RegisterItem", "<h3>You must provide a quantity !<br></h3>");
    	exit();
    }
    $description = NULL;
    if (isset($_POST['description']))
    {
    	$description = $_POST['description'];
    }
    else if (isset($_GET['description']))
    {
    	$description = $_GET['description'];
    }
    else
    {
    	$description = "No description";
    }

    getDatabaseLink($link);

    begin($link);
    // Add item to database
    $start = date("Y:m:d H:i:s");
    $end = date("Y:m:d H:i:s", mktime(date("H"), date("i"),date("s"), date("m"), date("d")+$duration, date("Y")));
    $result = mysql_query("INSERT INTO items VALUES (NULL, \"$name\", \"$description\", $initialPrice, $qty, $reservePrice, $buyNow, 0, 0, '$start', '$end', $userId, $categoryId)", $link) or die("ERROR: Failed to insert new item in database. MySQL reports '".mysql_error()."' while querying 'INSERT INTO items VALUES (NULL, \"$name\", \"$description\", $initialPrice, $qty, $reservePrice, $buyNow, '$start', '$end', $userId, $categoryId)'");
    commit($link);

    printHTMLheader("RUBiS: Selling $name");
    print("<center><h2>Your Item has been successfully registered.</h2></center><br>\n");
    print("<b>RUBiS has stored the following information about your item:</b><br><p>\n");
    print("<TABLE>\n");
    print("<TR><TD>Name<TD>$name\n");
    print("<TR><TD>Description<TD>$description\n");
    print("<TR><TD>Initial price<TD>$initialPrice\n");
    print("<TR><TD>ReservePrice<TD>$reservePrice\n");
    print("<TR><TD>Buy Now<TD>$buyNow\n");
    print("<TR><TD>Quantity<TD>$qty\n");
    print("<TR><TD>Duration<TD>$duration\n"); 
    print("</TABLE>\n");
    print("<br><b>The following information has been automatically generated by RUBiS:</b><br>\n");
    print("<TABLE>\n");
    print("<TR><TD>User id<TD>$userId\n");
    print("<TR><TD>Category id<TD>$categoryId\n");
    print("</TABLE>\n");
    
    mysql_close($link);
    
    printHTMLfooter($scriptName, $startTime);
    ?>
  </body>
</html>
