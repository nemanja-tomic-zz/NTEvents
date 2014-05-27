<?php
interface IEvent {
	public function attach(IEventHandler $listener);
	public function detach(IEventHandler $listener);
	public function fire($sender, IEventArgs $eventArgs);
}
interface IEventHandler {
	public function Invoke($sender, IEventArgs $eventArgs);
}
interface IEventArgs {
	public function __construct($data);
}
class EventHandler implements IEventHandler {

	private $owner;
	private $method;

	public function __construct($owner, $methodName) {
		$this->owner = $owner;
		$this->method = new \ReflectionMethod($owner, $methodName);
		$this->method->setAccessible(true);
	}

	public function Invoke($sender, IEventArgs $eventArgs) {
		$this->method->invoke($this->owner, $sender, $eventArgs);
	}

}
class Event implements IEvent {

	private $eventHandlers;

	public function __construct() {
		$this->eventHandlers = array();
	}

	public function attach(IEventHandler $observer) {
		$this->eventHandlers[] = $observer;
	}

	public function detach(IEventHandler $observer) {
		//unset($this->observers[$observer]);
	}

	public function fire($sender, IEventArgs $args) {
		/** @var $eventHandler EventHandler */
		foreach ($this->eventHandlers as $eventHandler) {
			$eventHandler->Invoke($sender, $args);
		}
	}
}
class EventArgs implements IEventArgs {
	public $message;
	public $data;

	public function __construct($data) {
		$this->data = $data;
	}
}

class SomeController {
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
		$this->mySecondEvent->attach($callback);
	}

	public function MyEventDetach($callback) {
		$this->myEvent->detach($callback);
	}


}

class MyObserver {
	public function Main() {
		$controller = new SomeController();
		$controller->MyEventAttach(new EventHandler($this, "OnSomething"));
		$controller->createUser();
	}

	public function OnSomething($sender, EventArgs $eventArgs) {
		/** @var $someController SomeController */
		$someController = $sender;
		var_dump($someController->someValue);
		var_dump($eventArgs->data);
	}
}
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

$a = new MyObserver();
$a->Main();