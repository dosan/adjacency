<?php
class Session
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		session_start();
	}
	/**
	 * Destructor.
	 */
	public function __destruct()
	{
		unset($this);
	}
	/**
	 * Register the session.
	 *
	 * @param integer $time.
	 */
	public function register($time = 60)
	{
		$_SESSION['session_id'] = session_id();
		$_SESSION['session_start'] = $this->newTime();
		$_SESSION['session_time'] = intval($time);
	}
	/**
	 * Checks to see if the session is registered.
	 *
	 * @return  True if it is, False if not.
	 */
	public function isRegistered()
	{
		if (! empty($_SESSION['session_id'])) {
			return true;
		}
		return false;
	}
	/**
	 * Set key/value in session.
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	static public function set($key, $value)
	{
		$k = SES_PR . '_' . $key;
		$_SESSION[$k] = $value;
		return true;
	}
	/**
	 * Retrieve value stored in session by key.
	 *
	 * @var mixed
	 */
	static public function get($key)
	{
		$k = SES_PR . '_' . $key;
		if(isset($_SESSION[$k])) {
			return $_SESSION[$k];
		}
		return false;
	}
	/**
	 * Retrieve the global session variable.
	 *
	 * @return array
	 */
	public function getSession()
	{
		return $_SESSION;
	}
	/**
	 * Gets the id for the current session.
	 *
	 * @return integer - session id
	 */
	public function getSessionId()
	{
		return $_SESSION['session_id'];
	}
	/**
	 * Checks to see if the session is over based on the amount of time given.
	 *
	 * @return boolean
	*/
	public function isExpired()
	{
		if ($_SESSION['session_start'] < $this->timeNow()) {
			return true;
		}
		return false;
		
	}
	/**
	 * Renews the session when the given time is not up and there is activity on the site.
	 */
	public function renew()
	{
		$_SESSION['session_start'] = $this->newTime();
	}
	/**
	 * Returns the current time.
	 *
	 * @return unix timestamp
	 */
	private function timeNow()
	{
		$currentHour = date('H');
		$currentMin = date('i');
		$currentSec = date('s');
		$currentMon = date('m');
		$currentDay = date('d');
		$currentYear = date('y');
		return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear);
	}
	/**
	 * Generates new time.
	 *
	 * @return unix timestamp
	 */
	private function newTime()
	{
		$currentHour = date('H');
		$currentMin = date('i');
		$currentSec = date('s');
		$currentMon = date('m');
		$currentDay = date('d');
		$currentYear = date('y');
		return mktime($currentHour, ($currentMin + $_SESSION['session_time']), $currentSec, $currentMon, $currentDay, $currentYear);
	}
	/**
	 * Destroys the session.
	 */
	public function end()
	{
		session_destroy();
		$_SESSION = array();
	}
}