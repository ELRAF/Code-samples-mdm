# Code-samples

The 3 php files are a sample selected to illustrate the thought process which drives https://www.mydocentsmanager.net/demo application (a browser-based docents management system). 
This application was developed from existing (php/mysql) procedural websites. The application incorporates all of the original websites’ features into a comprehensive system.

1- All classes are required and instantiated in index.php

2- Index.php is sub-divided into a HEAD area, HEADER area and CONTENT area (there is no footer in this instance).

3- Each area calls the appropriate class: 
a processing class is called first (above html)
then the javascript class is called in the HEAD
the headers class in HEADER
the content class in CONTENT

4- Contents.php provides all the necessary functions to make stuff happen in the CONTENT area. In some cases, where the functionalities are more complex, like the hours management page, the functions in the contents class bring in other classes (such as hours.php)

5- This is an ongoing project
