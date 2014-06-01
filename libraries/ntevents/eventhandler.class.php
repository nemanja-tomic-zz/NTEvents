<?php
namespace NTEvents {

	class EventHandler implements IEventHandler {
		private $owner;
		/**
		 * @var \ReflectionMethod
		 */
		private $methodInfo;
		/**
		 * @var \ReflectionParameter[]
		 */
		private $parameters;

		/**
		 * @param $owner object Owned of the method (The class containing method definition).
		 * @param $methodName string Must be a method which accepts two arguments of following types: (object, IEventArgs).
		 * @throws \InvalidArgumentException
		 */
		public function __construct($owner, $methodName) {
			if ($owner == null || $methodName == null) {
				throw new \InvalidArgumentException("Null argument passed.");
			}

			$this->owner = $owner;
			$this->methodInfo = new \ReflectionMethod($owner, $methodName);
			$this->methodInfo->setAccessible(true);
			$this->parameters = $this->methodInfo->getParameters();

			if (count($this->parameters) != 2 || !$this->parameters[1]->getClass()->implementsInterface("NTEvents\\IEventArgs")) {
				throw new \InvalidArgumentException("Provided method cannot be resolved as event handler. Please provide method with 2 arguments, with one argument of IEventArgs type.");
			}

		}

		public function invoke($sender, IEventArgs $eventArgs) {
			$this->methodInfo->invoke($this->owner, $sender, $eventArgs);
		}

	}
}