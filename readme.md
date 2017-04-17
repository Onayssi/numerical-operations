# What is it?
 This is a command line PHP Application that reads lines of text from a file in the special format.
 The application handles the operations related to a specific instructions, taking an instruction name and list of integers values in  reason to execute and output the result. 
 
# The Latest Version
This is the first version of the script (V1.0).

# Documentation
The package includes the files and folders below:
  - "data" : folder including the text file which would be provided to run the script.
  - "data/operations.php" : Text file containing the instructions to be executed (line by line).
  - "database" : folder including the sql file (database related).
  - "database/operations.sql" : the sql file concerning the database and tables related to the script (used to save the operations).
  - "query.php" : Script concerning the connection to mysql database using PDO object (which would be required).
  - "operations" : The main script that running the application, including the functions and instructions that are handling the request. 
  
# Requirements
- Apache Server for Windows or Linux (XAMPP / WAMP / LAMP / MAMP / Online Host).
- PHP version 5.X and plus.
- Mysql Database Driven.
- PHP must set in the global variables environment in order to use it from CLI.
  
# Installation
To assure that the php environment is installed on the machine, run the command below and check the output:
  * php -v

In case of succes, the result would be like the below:

[PHP 5.5.12 (cli) (built: Apr 30 2014 11:20:58)<br>
Copyright (c) 1997-2014 The PHP Group<br>
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies<br>
with Xdebug v2.2.5, Copyright (c) 2002-2014, by Derick Rethans].

After providing the requirements, select the main directory of the apache server, the root directory, www/ or htdocs, to put the package inside the root, you can create a "operations" folder as a main directory for the application, then put all the files related inside it.
Launch the MySQL server, and create a new database called ("operations" for example, you can change the name from the query.php file), import the operations.sql file from the sql folder and the run the execute command.
  
# Running Application
  [We disabled running the code using web browser, in reason to be more clarified, anyway, it would be working without the TEXT File 
  argument].<br>
  Open the cmd.exe soft, the CLI, navigate to the destination directory, and run the command below:
  * php operations.php --file=operations.txt

For the game events (jeux de cas), you can check the output errors by altering the command, i.e.:
  * php operations.php --file
  * php operations.php --file=
  * php operations.php --file=(ANY_FILE_NAME).txt 
  * php operations.php --file=(FILE_NAME).pdf
  * php operations.php --(ANY_SYNTAX)=(FILE_NAME).<EXT> 
 
# License
Copyright (c) 2010-2017 Mouhamad Ounayssi.<br>
Blog: https://www.mouhamadounayssi.wordpress.com.
