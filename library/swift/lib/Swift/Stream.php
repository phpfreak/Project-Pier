<?php

/**
 * Provides a custom registered stream for use with a transport protocol
 * This is part of the Swift Mailer unit testing stuff.
 * It uses a command processor to do that actual reading/writing
 */
class Swift_Stream
{
	/**
	 * The command processor
	 * @var object singleton processor
	 */
	private $processor;
	
	/**
	 * PHP's call back for fopen() actions on the fake stream
	 */
	public function stream_open($path, $mode, $options, &$opened_path)
	{
		$this->processor = Swift_Stream_Processor::getInstance();
		$this->processor->isOpen = true;
		return $this->processor->isOpen;
	}
	/**
	 * PHP Callback for fread() fgets() etc
	 */
	public function stream_read($size)
	{
		return $this->processor->getResponse($size);
	}
	/**
	 * fwrite() callback
	 */
	public function stream_write($string)
	{
		if ($this->processor->isOpen)
		{
			$this->processor->setCommand($string);
			return strlen($string);
		}
		else return 0;
	}
	/**
	 * Only here to prevent errors
	 */
	public function stream_eof()
	{
		//Does nothing... SMTP doesn't implement it
		// It's vital we can work this out ourselves
	}
	/**
	 * Singletons never really get destroyed much, this just nulls it out
	 */
	public function stream_close()
	{
		$this->processor->destroy();
	}
}

//Registers a stream which can be accessed as swift://url
stream_wrapper_register('swift', 'Swift_Stream');

?>