<?php
//First we include the Tropo WebAPI classes.
require('tropo.class.php');


//The next step is to determin the URI (or position) within the script the caller is at.
//To do this we use a GET method to find the URI from the url which Tropo is requesting in the background.
$uri = $_GET['uri'];


//In this example I have decided to create a function to deal with the MySQL connection as it is going to be needed/called at multple points in the script
function connectToMySQL(){
  $db_user = "root";
  $db_pass = "root";
  $db_db = "Tropo";
  mysql_connect("localhost", $db_user, $db_pass) or die("ERROR: MySQL cannot connect.");
  mysql_select_db($db_db) or die("ERROR: MySQL cannot select database.");	
}


//Now we want to be able to execute different lines of code when different URI's are called (when the caller is at different stages in the call).
//This can be done by using IF and ELSEIF statements but we're going to keep things simple and use SWITCH, CASE, BREAK and DEFAULT.
switch ($uri)
{
  //Everything between case "start": and the break; commands will be run when Tropo initially requests the script using voice.php?uri=start in the URL.
  case "start":
  //We are going to need a connection to MySQL in this section so we include the function we created to deal with the MySQL connection.
  connectToMySQL();

  //We also need to know various details about the caller, we can create an instance of the Session() object which deals with retreiving these 
  //details from the initial JSON data request which is sent to this script from Tropo when a new call is received.
  $tropoSession = new Session();

  //Below demonstrates how we can retreive data from our new Session() object and store those details (or in some cases arrays) into local variables,
  //which I've given names that are easier to understand.
  $call_id = $tropoSession->getCallId();

  //The below line sets $caller_from as an array which has all of the FROM data passed accross in the JSON request.
  $caller_from = $tropoSession->getFrom();

  //Below we can see how that information stored in $caller_from can be accessed and pulled out into other variables. 
  $caller_number = $caller_from['id'];
  $caller_channel = $caller_from['channel'];
  $caller_network = $caller_from['network'];

  //This is a very basic MySQL query which can be used to insert data into the MySQL database table called 'calls' which stores 
  //the call id, the callers phone number (or skype username etc), the channel used (voice or text) as well as the network which could be 
  //SIP, SKYPE, etc.
  mysql_query("INSERT INTO `calls` (callId, number, channel, network) VALUES ('".$call_id."', '".$caller_number."', '".$caller_channel."', '".$caller_network."')");

  //We create a new instance of the Tropo() object which we use to process commands on the Tropo service.
  $tropo = new Tropo();

  //This line of code simply sets up Tropo to speak the string data which is inbetween the quote marks.
  $tropo->say("Welcome to the PHP code sample system.");


  //The below record function speaks out to the user asking them to record their message and then asks them to press the hash key 
  //to continue and save their message. Note that the URL will have to be changed so that it corrosponds with your own server/hosting.
  //You will also need to set the username and password options to the FTP details of your server/hosting before this script will work.

  //You can look up the record webapi function on the Tropo documentation website for a better explanation of the below options.
  $tropo->record(array(
    'name' => 'recording',
    'say' => 'Please leave your message after the beep. Press the hash key when you are finished recording your message.',
    'url' => 'http://yourWebsite/recordings/recording.php?name='.$call_id,
  'terminator' => '#',
  'bargein' => 'false',
    'beep' => 'true',
    'timeout' => 10,
    'maxSilence' => 7,
    'maxTime' => 180,
    'format' => 'audio/wav',
    ));


  //Now we need to set some events and commands to be run when they are executed.
  //The first on event we will be executed if the recording (or prior) command is completed successfully.
  //This simply says to Tropo that we need to go to the voice.php?uri=continue URL (and run the code for that section) as well as speaking out the 
  //text from the say command so the caller knows everything has gone well.
  $tropo->on(array("event" => "continue", "next" => "voice.php?uri=continue", "say" => "Thank you, here is the message you have just recorded."));


  //We also needd to know what to do in the case of an error. Instead of getting Tropo to start executing the success (?uri=continue) code we instead
  //ask Tropo to access the incomplete URI instead.
  $tropo->on(array("event" => "incomplete", "next" => "voice.php?uri=error"));


  //Now we have told the Tropo object what we want to do we need to get the object to render our the JSON code which will be outputted onto the page 
  //for the Tropo service to read and execute. It is crucial that you remember to render your JSON as this step makes the "instructions" you've just 
  //created readable by Tropo.
  $tropo->renderJSON();

  //We also want to close the MySQL database connection.
  mysql_close();

  //The break command simply signals that we are at the end of the code which will be executed for the "start" URI.
  break;

  case "continue":
  //As with the start case we need MySQL access so lets add that in by calling the function we created earlier.
  connectToMySQL();

  //As we are expecting to have received JSON data back from the Tropo service we need to initiate an instance of the Result() object.
  $result = new Result();

  //Now we have read in the resulting JSON data we can access it through the Result() object we have just created. We need the calls id so that we
  //know what data to store along side the recording the caller has just created and to track the call in general.
  $call_id = $result->getCallId();

  //Insert the new recording into the MySQL database table called 'recordings', make sure you change the URL so that it corosponds to your 
  //own server/hosting or this wont work.
  mysql_query("INSERT INTO `recordings` (callId, recording_url) VALUES ('".$call_id."', 'http://yourWebsite/recordings/".$call_id.".wav')");	


  //Create a new Tropo object.
  $tropo = new Tropo();

  //Replay the recording back to the caller and speak out "Good bye" after the recording has finished. Make sure you change the URL to work properly with
  //your own server/hosting.
  $tropo->say("http://yourWebsite/recordings/".$call_id.".wav Good bye.");

  //Hang up the call.
  $tropo->hangup();

  //Render the JSON to be read back by the Tropo service.
  $tropo->renderJSON();

  //Close the MySQL database connection.
  mysql_close();

  //Signal the end of the continue case section.
  break;

  case "error":
  //The code in between case "error": and break; is used when our error event is called which we set up in the start case.
  //First we create a new instance of the Tropo object.
  $tropo = new Tropo();

  //Next we use the say method to tell the user that an error has occured and that they should call back to try again.
  $tropo->say("Sorry I can't hear anything. Check your microphone isn't on mute and call back to try again. Good Bye.");

  //Hangup the call.
  $tropo->hangup();

  //Render the JSON which will be used to 
  $tropo->renderJSON();
  break;

  default:
  //The default case is used in the event that the URI in the URL (?uri=) is left blank or doesn't match one of the above cases we have identified.
  //We simply want to die() the script in the case that this is called for security as it is most likely a security threat.
  die("An error has occured.");
  break;
}
?>