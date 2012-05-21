<?php
//First we need to create a connection to our MySQL database and also set up some details into variables for the database connection.
$db_user = "User_Name";
$db_pass = "Password";
$db_db = "Database_Name";
//We use the details we've stored into our variables to connect to the database.
mysql_connect("localhost", $db_user, $db_pass) or die("ERROR: MySQL cannot connect.");

//Next we need to select the database which we wish to work with.
mysql_select_db($db_db) or die("ERROR: MySQL cannot select database.");	

//Next we get all of the data from our calls table of the database.
$calls_sql = mysql_query("SELECT * FROM `calls`");

//We then want to set up a while loop which will allow us to output the details for each individual row of the table as it loops.
while($call = mysql_fetch_object($calls_sql)){

  //The below 7 lines of code are used to simply obscure the telephone numbers and skype usernames to only display the last 4 characters for privacy reasons.
  $length = strlen($call->number);
  $starlength = $length - 4;	
  $number = "";
  for ($i = 1; $i <= $starlength; $i++){
    $number .= "*";
  }
  $number .= substr($call->number , $starlength ,4);
  //------------------------------------------------

  //We then use the echo command to construct the HTML markup which will be used to create the page the user will see when they are viewing the calls and 
  //recordings. Notice how we close and open quote marks so we can join in the PHP variables which are then printed out to the page HTML source.
  echo "<strong>CALL ID:</strong> ".$call->callId." <strong>CALL FROM:</strong> ".$number." <strong>CALL CHANNEL:</strong> ".$call->channel." <strong>CALL NETWORK:</strong> ".$call->network." <strong>TIMESTAMP:</strong> ".$call->timestamp."<br />";

  //While we are printing out the details for a call we also want to print out any recordings which corrospond to the call. I've opted to use
  //a while loop for this incase you wish to change the script slightly so that it can allow for multiple recordings per call. This is also the best way
  //to output calls which might not actually have a recording at all due to hanging up or an error when they record their message.
  $recordings_sql = mysql_query("SELECT * FROM `recordings` WHERE `callId` = '".$call->callId."'");

  //So this basically echos out a link to the audio file we have stored into the database.
  while($recording = mysql_fetch_object($recordings_sql)){
    echo "<strong>@ RECORDING URL</strong> <a href='".$recording->recording_url."'>Listen</a><br />";
  }

  //After every call we want to have 2 line breaks to make it a little easier to read our index.
  echo "<br /><br />";
}
?>