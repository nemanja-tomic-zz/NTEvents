<?php
namespace NTEvents {
	interface IEventHandler {
		public function invoke($sender, IEventArgs $eventArgs);
	}
}