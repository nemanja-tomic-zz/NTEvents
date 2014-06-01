<?php
namespace NTEvents {
	class EventArgs implements IEventArgs {
		public $message;
		public $data;

		public function __construct($data) {
			$this->data = $data;
		}

		public static function NoArgs() {
			return new EventArgs("");
		}
	}
}