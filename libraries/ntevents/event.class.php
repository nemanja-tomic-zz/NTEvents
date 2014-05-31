<?php
namespace NTEvents {
	class Event implements IEvent {

		/**
		 * @var IEventHandler[]
		 */
		public $eventHandlers;

		public function __construct() {
			$this->eventHandlers = array();
		}

		public function attach(IEventHandler $observer) {
			$this->eventHandlers[] = $observer;
		}

		public function detach(IEventHandler $observer) {
			if (($key = array_search($observer, $this->eventHandlers)) !== false) {
				unset($this->eventHandlers[$key]);
			}
		}

		public function fire($sender, IEventArgs $args) {
			foreach ($this->eventHandlers as $eventHandler) {
				$eventHandler->invoke($sender, $args);
			}
		}
	}
}