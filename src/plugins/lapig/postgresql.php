<?php
// no direct access
//defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Example system plugin
 */
class plgLapigPostgreSQL extends JPlugin
{
	private $port,
	        $host,
	        $dbname,
	        $username,
	        $password;
	
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgLapigPostgreSQL( &$subject, $config )
	{
		parent::__construct( $subject, $config );

		$this->port=$this->params->get('port');
        $this->host=$this->params->get('host');
        $this->dbname=$this->params->get('dbname');
        $this->username=$this->params->get('username');
        $this->password=$this->params->get('password');
	}

	private function openConnection() {
		$argsConnection="host=$this->host  dbname=$this->dbname port=$this->port user=$this->username password=$this->password";
        $this->connection = pg_connect($argsConnection);
        
        return $this->connection;
	}

	private function closeConnection() {
            pg_close($this->connection);
    }
	
    public function sendQuery($query) {
    	$this->openConnection();
    	
    	$result = pg_query($query);
    	
    	$this->closeConnection();
    	
    	return pg_fetch_all($result);
    }
    
	public function getConfigsLapigPostgreSQL()
	{
		echo 'Port:'     .$this->port     .'<br>';
		echo 'Host:'     .$this->host     .'<br>';
		echo 'Dbname:'   .$this->dbname   .'<br>';
		echo 'Username:' .$this->username .'<br>';
		echo 'Password:' .$this->password .'<br>';
	}
}

?>