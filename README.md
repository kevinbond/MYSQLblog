#File Usage

###KLogger.php
+ This is the logging file which will log sucesses and errors when saving the recording

###SQL-CODE-TO-CREATE-TABLES.sql
+ This is the sql file which creates a MYSQL database 
+ This will create a database named **Tropo** with two tables named **calls** and **recordings**

###compatibility.php
+ This will check your PHP version to check for compatibility 

###recording.php
+ This is a PHP app which will receive a record audio file and save it using the name variable that is passed in the query string
+ An example URL to send the audio file would look like - **http://www.youServer.com/recording.php?name=recording**

###TropoClasses.php, tropo-rest.class.php, tropo.class.php
+ These are all apart of the Tropo webAPI library

###voice.php
+ This is the actual Tropo app 
+ The URL for this app needs to have a query string with uri=start as a parameter
+ An example URL that you can use would be - http://www.yourServer.com/voice.php?uri=start

###index.php
+ This PHP script will access the Tropo information which was saved in the MYSQL database and post it to the browser
+ You can enter the following URL in the bowser to view the information: http://www.yourServer.com/index.php
+ You can view a sample out put would look like below:


![Database call](https://img.skitch.com/20120522-bsd49isappgqp678xpax5mry3t.jpg)