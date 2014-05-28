<?php
namespace NTEvents {
	class Event implements IEvent {

		/**
		 * @var array(IEventHandler)
		 */
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
				$eventHandler->invoke($sender, $args);
			}
		}
	}
}