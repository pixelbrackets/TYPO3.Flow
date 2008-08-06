<?php

declare(ENCODING = 'utf-8');

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package FLOW3
 * @subpackage Session
 * @version $Id:$
 */

/**
 * A simple session based on PHP session functions.
 *
 * @package FLOW3
 * @subpackage Session
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class F3_FLOW3_Session_PHP implements F3_FLOW3_Session_Interface {

	/**
	 * The session Id
	 *
	 * @var string
	 */
	protected $sessionId;

	/**
	 * If this session has been started
	 *
	 * @var boolean
	 */
	protected $started = FALSE;

	/**
	 * Constructor.
	 *
	 * @return void
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function __construct() {
		if(ini_get('session.auto_start') != 0) throw new F3_FLOW3_Session_Exception_SessionAutostartIsEnabled();
	}

	/**
	 * Starts the session, if is has not been already started
	 *
	 * @return void
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function start() {
		if($this->started === FALSE) {
			session_start();
			$this->sessionId = session_id();
			$this->started = TRUE;
		}
	}

	/**
	 * Returns the current session ID.
	 *
	 * @return string The current session ID
	 * @throws F3_FLOW3_Session_Exception_SessionNotStarted
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function getID() {
		if ($this->started !== TRUE) throw new F3_FLOW3_Session_Exception_SessionNotStarted('The session has not been started yet.', 1218043307);
		return $this->sessionId;
	}

	/**
	 * Returns the data associated with the given key.
	 *
	 * @param string $key An identifier for the content stored in the session.
	 * @return mixed The contents associated with the given key
	 * @throws F3_FLOW3_Session_Exception_SessionNotStarted
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function getData($key) {
		if ($this->started !== TRUE) throw new F3_FLOW3_Session_Exception_SessionNotStarted('The session has not been started yet.', 1218043308);
		return (key_exists($key, $_SESSION)) ? $_SESSION[$key] : NULL;
	}

	/**
	 * Stores the given data under the given key in the session
	 *
	 * @param string $key The key under which the data should be stored
	 * @param mixed $data The data to be stored
	 * @return void
	 * @throws F3_FLOW3_Session_Exception_SessionNotStarted
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function putData($key, $data) {
		if ($this->started !== TRUE) throw new F3_FLOW3_Session_Exception_SessionNotStarted('The session has not been started yet.', 1218043309);
		$_SESSION[$key] = $data;
	}

	/**
	 * Explicitly writes and closes the session
	 *
	 * @return void
	 * @throws F3_FLOW3_Session_Exception_SessionNotStarted
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function close() {
		if ($this->started !== TRUE) throw new F3_FLOW3_Session_Exception_SessionNotStarted('The session has not been started yet.', 1218043310);
		session_write_close();
		unset($_SESSION);
	}

	/**
	 * Explicitly destroys all session data
	 *
	 * @return void
	 * @throws F3_FLOW3_Session_Exception_SessionNotStarted
	 * @author Robert Lemke <robert@typo3.org>
	 */
	public function destroy() {
		if ($this->started !== TRUE) throw new F3_FLOW3_Session_Exception_SessionNotStarted('The session has not been started yet.', 1218043311);
		session_destroy();
		unset($_SESSION);
	}
}

?>