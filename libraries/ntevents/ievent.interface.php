<?php
namespace NTEvents {
	interface IEvent {
		public function attach(IEventHandler $listener);
		public function detach(IEventHandler $listener);
		public function fire($sender, IEventArgs $eventArgs);
	}
}