<?php
//////////////////////////////////////////////////////////////////////////
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

spl_autoload_register(function($class){
	set_include_path(get_include_path() . PATH_SEPARATOR . 'libraries/');
	spl_autoload_extensions('.class.php,.interface.php,.library.php');
	spl_autoload(strtolower($class));
});

use NTEvents\Event;
use NTEvents\EventArgs;
use NTEvents\EventHandler;

$a = new MyObserver();
$a->Main();

class Observed {
	/**
	 * @var Event
	 */
	private $myEvent;
	/**
	 * @var Event
	 */
	private $mySecondEvent;

	public $someValue;

	public function __construct() {
		$this->myEvent = new Event();
		$this->mySecondEvent = new Event();
	}

	public function createUser() {
		$this->someValue = 1;
		$this->myEvent->fire($this, new EventArgs("lala"));
		$this->someValue = 2;
		$this->mySecondEvent->fire($this, new EventArgs("baba"));
	}

	public function MyEventAttach(EventHandler $callback) {
		$this->myEvent->attach($callback);
	}

	public function MyEventDetach($callback) {
		$this->myEvent->detach($callback);
	}

	public function DumpEventHandlers() {
		var_dump(count($this->myEvent->eventHandlers));
	}

}
class MyObserver {

	public function Main() {
		$controller = new Observed();
		$controller->MyEventAttach(new EventHandler($this, "OnSomething"));
		$controller->MyEventAttach(new EventHandler($this, "OnOtherSomething"));
		$controller->createUser();
		$controller->MyEventDetach(new EventHandler($this, "OnSomething"));
		$controller->createUser();
	}

	public function OnSomething($sender, EventArgs $eventArgs) {
		/** @var $someController Observed */
		$someController = $sender;
		var_dump($someController->someValue);
		var_dump($eventArgs->data);
	}

	public function OnOtherSomething($sender, EventArgs $eventArgs) {
		var_dump("PENIS".$eventArgs->data);
	}
}