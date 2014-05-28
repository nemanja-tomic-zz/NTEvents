<?php
namespace NTEvents {
	class EventHandler implements IEventHandler {

		private $owner;
		private $method;

		public function __construct($owner, $methodName) {
			$this->owner = $owner;
			$this->method = new \ReflectionMethod($owner, $methodName);
			$this->method->setAccessible(true);
		}

		public function invoke($sender, IEventArgs $eventArgs) {
			$this->method->invoke($this->owner, $sender, $eventArgs);
		}

	}
}