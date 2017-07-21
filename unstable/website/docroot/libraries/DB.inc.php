<?php
# ===========================================================================
# Project:              Job Tracker
# Project Leader:       Peter Wise
# Project Module:       Database Abstraction Class
# ---------------------------------------------------------------------------
# Module name:          Database
# Module comment:       none
# Module filename:      DB.inc.php
# ---------------------------------------------------------------------------
/* $Id: DB.inc.php,v 1.1 2003/06/10 22:30:19 simon2675 Exp $ */
# ---------------------------------------------------------------------------
# Notes
# ===========================
# Written by and owned by Simon Proctor. 
# 
# This code is protected under the Gnu Public License (See LICENSE).
# ===========================================================================

class Database
{
        # -----------------------------------------------------------------------
        # Class variables
        # -----------------------------------------------------------------------

        var $database;          # The database
        var $host;              # Where it is
        var $username;          # Who we connect as
        var $password;          # Connection auth.

        var $dbh;                       # The active connection
        var $error;                     # The last error generated

        # =======================================================================
        # Function:             CONSTRUCTOR
        # Class:                        Database
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # database                      String          Database (optional)
        # host                          String          Host (optional)
        # username                      String          Username (optional)
        # password                      String          Password (optional)
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # Class constructor.
        # =======================================================================

        function Database($data = '',$host ='',$user ='',$pass='')
        {
                # Let me go! We will not let you go! Let me go!
                $this->database = $data;
                $this->host = $host;
                $this->username = $user;
                $this->password = $pass;
        }

        # =======================================================================
        # Function:             connect
        # Class:                Database
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # results                       Boolean         If connection was successful
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # Connects to the chosen database then called selectDatabase() to choose
        # the actual database we want.
        # =======================================================================

        function connect()
        {
                # Attempt to connect
                $this->dbh = mysql_connect(
                        $this->host,
                        $this->username,
                        $this->password
                );

                # Did we connect?
                if(!$this->dbh)
                {
                        # No :/
                        $this->error = mysql_error();
                        return false;
                }

                # Select our database
                if($this->selectDatabase())
                {
                        # Well its about time
                        return true;
                }
                else
                {
                        $this->error = mysql_error();
                        return false;
                }
        }

        # =======================================================================
        # Function:             selectDatabase
        # Class:                Database
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # results                       Boolean         If selection was succesful
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # Chooses a database to use, hence requires an active connection. This is
        # automatically called by connect().
        # =======================================================================

        function selectDatabase()
        {
                # Woot :P
                if(!(mysql_select_db($this->database,$this->dbh)))
                {
                        $this->error = mysql_error();
                        return false;
                }
                return true;
        }

        # =======================================================================
        # Function:             disconnect
        # Class:                Database
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # Closes the database connection.
        # =======================================================================

        function disconnect()
        {
                mysql_close($this->dbh);
        }

        # =======================================================================
        # Function:             error
        # Class:                Database
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # error                         String          The last database error returned
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # In case of errors, anything returned from MySQL is trapped and made
        # available from this function.
        # =======================================================================

        function error()
        {
                return $this->error;
        }

        # =======================================================================
        # Function:             executeQuery
        # Class:                Database
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # query                         String          The SQL
        # args                          Array           The parameters
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # results                       DB ref.         The reference to the database
        #                                               results
        # false                         boolean         Failure
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # In case of errors, anything returned from MySQL is trapped and made
        # available from this function.
        # =======================================================================

    function executeQuery($query, $args, $array = false)
    {
        if (! is_array($args))
        {
            $args = array($args);
        }

                  $offset = false;

        while (list($key,$value) = each($args))
        {
            $val = mysql_escape_string($value);
                                $pos = false;
                                if($offset === false)
                                {
                $pos = strpos($query,'?');
                                }
                                else
                                {
                                        $pos = strpos($query, '?', $offset);
                                }

            if ($pos !== false)
            {
                $start = substr($query,0,$pos);
                $end = substr($query,$pos+1);
                $query = "$start$val$end";
                                         $offset = strlen($start) + strlen($val);
            }
        }

        $result = mysql_query($query,$this->dbh);

                if(!$result)
                {
                        $this->error =  mysql_error();
                        return false;
                }
                else
                {
                        # return $result;
                        if($array)
                        {
                                $temp = array();
                                while ($row = mysql_fetch_assoc($result))
                                {
                                        foreach ($row as $key => $value)
                                        {
                                                $row[$key] = stripslashes($value);
                                        }

                                        array_push($temp, $row);
                                }

                                mysql_free_result($result);

                                return $temp;
                        }
                        else
                        {
                                return $result;
                        }
                }
    }

        # =======================================================================
        # Function:             setDatabaseConnection
        # Class:                WebUser
        # -----------------------------------------------------------------------
        # Parameter                     Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # db                            Database        The database object
        # -----------------------------------------------------------------------
        # Returns                       Type            Usage
        # ~~~~~~~~~~~~~~~~~~~~~~~~      ~~~~~~~~~~~     ~~~~~~~~~~~~~~~~~~~~~~~~~
        # None
        # -----------------------------------------------------------------------
        # Notes:
        # ~~~~~~
        # Sets the active database connection - no test is performed to test for
        # validity.
        # =======================================================================

        function setDatabaseConnection($db)
        {
                $this->dbh = $db;
        }

        function setDatabaseSettings($data = '',$host ='',$user ='',$pass='')
        {
                $this->database = $data;
                $this->host = $host;
                $this->username = $user;
                $this->password = $password;
        }

} # End
?>


