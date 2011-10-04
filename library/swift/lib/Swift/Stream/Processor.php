<?php

interface Swift_IStream
{
	/**
	 * Accept a command in the form of a string
	 * The observer will write to our response buffer itself.
	 * @param string command
	 */
	public function command(&$command);
}

class Swift_Stream_Processor
{
	/**
	 * Singleton Instance
	 * @var object FakeStream_CommandProcessor
	 */
	static private $instance = null;
	/**
	 * The current command being written
	 * @var string command
	 */
	public $command;
	/**
	 * The unread response, get regularly truncated from the pointer pos
	 * @var string resonse buffer
	 */
	public $response = "";
	/**
	 * Observer collection
	 * The actual logic is handled by an observer
	 * @var array observer objects
	 */
	private $observers = array();
	/**
	 * Boolean value is the handle is active
	 * @var bool stream open
	 */
	public $isOpen = false;
	/**
	 * Streams with no EOF hang indefinitely if you try to read too far
	 * We don't want that to happen in testing since it will stop the tests from completing
	 * So intead we set a value to true if it *would be* hanging, and this we can test for it
	 */
	public $hanging = false;
	
	private function __construct() {}
	/**
	 * Load an observer in
	 * @param object observer
	 */
	public function addObserver(Swift_IStream $observer)
	{
		$this->observers[] = $observer;
	}
	/**
	 * Singleton factory
	 */
	static public function getInstance()
	{
		if (self::$instance === null) self::$instance = new Swift_Stream_Processor();
		return self::$instance;
	}
	/**
	 * Provide a command and store it on the buffer
	 * @param string command
	 */
	public function setCommand($command)
	{
		$this->command .= $command;
		foreach ($this->observers as $i => $o) $o->command($this->command);
	}
	/**
	 * Add a response to the response buffer
	 * @param string response
	 */
	public function setResponse($response)
	{
		$this->response .= $response."\r\n";
	}
	/**
	 * Read the response from the response buffer
	 * Then advance the pointer
	 * @return string response
	 */
	public function getResponse($size)
	{
		$ret = substr($this->response, 0, $size);
		
		$this->response = substr($this->response, $size);
		
		//Fake SMTP's behaviour of hanging past EOF
		if (!strlen($ret)) $this->hanging = true;
		else $this->hanging = false;
		
		return $ret;
	}
	/**
	 * For testing purposes we can see if the stream would be hanging in the real world
	 * @return bool hanging
	 */
	public function isHanging()
	{
		return $this->hanging;
	}
	/**
	 * Kill the singleton
	 */
	public function destroy()
	{
		self::$instance = null;
		$this->isOpen = false;
	}
}

?>