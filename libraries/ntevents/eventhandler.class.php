<?php
namespace NTEvents {
	class EventHandler implements IEventHandler {

		private $owner;
		private $method;

		public function __construct($owner, $methodName) {
			$this->owner = $owner;
			$this->method = new \ReflectionMethod($owner, $methodName);

			$params = $this->method->getParameters();
			if (count($params) != 2 || $params[1]->getClass()->name != get_class(new EventArgs(""))) {
				throw new \InvalidArgumentException("Provided method must have exactly two arguments and the second argument must be of EventArgs type.");
			}
			$this->method->setAccessible(true);
		}

		public function invoke($sender, IEventArgs $eventArgs) {
			$this->method->invoke($this->owner, $sender, $eventArgs);
		}

	}
}