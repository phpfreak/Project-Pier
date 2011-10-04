<?php

/*
 An example of how to write a plugin for Swift.
 
 You should read Plugin_API in docs fully before writing
  your own plugins
 */

class Swift_Plugin_Example implements Swift_IPlugin
{
	// ** Required ** - Identifies this plugin
	public $pluginName = "Example";
	
	protected $SwiftInstance;
	
	//Optional - run when the user instantiates the plguin
	public function __construct()
	{
		//
	}
	
	// ** Required ** - Swift loads passes itself here
	public function loadBaseObject(&$object)
	{
		$this->SwiftInstance =& $object;
		
		echo "SwiftInstance loaded into plugin...<br />";
	}

	public function onLoad()
	{
		echo "Plugin loaded fully...<br />";
	}

	public function onError()
	{
		echo "An error has occured.  See this error log:<br />";
		print_r($this->SwiftInstance->errors);
	}

	public function onBeforeSend()
	{
		echo "A message is about to be sent...<br />";
		$commands = $this->SwiftInstance->currentMail;
		
		echo "Here's the message data...<br />".
		$commands[3];
		
		$commands[3] = preg_replace('/\d+/', '{NUMBER}', $commands[3]);
		
		$this->SwiftInstance->currentMail = $commands;
		
		echo "But here's what Swift is about to send now...<br />".
		$commands[3];
	}

	public function onSend()
	{
		echo "A message was sent...<br />";
	}

	public function onClose()
	{
		echo "Swift has closed the connection...<br />";
	}

	public function onFail()
	{
		echo "Swift has failed, nothing else will execute, let's override it!<br />";
		$this->SwiftInstance->failed = false;
	}
}

?>