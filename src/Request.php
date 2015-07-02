<?php

namespace Zumba\VanillaJsConnect;

class Request {
		protected $client_id;

		public function __construct(array $args) {
			if(isset($args['client_id'])) {
				$this->client_id = $args['client_id'];
			}

			if(isset($args['timestamp'])) {
				$this->timestamp = $args['timestamp'];
			}

			if(isset($args['signature'])) {
				$this->signature = $args['signature'];
			}

			if(isset($args['callback'])) {
				$this->callback = $args['callback'];
			}
		}

		public function getClientID() {
			return $this->client_id;
		}

		public function getTimestamp() {
			return $this->timestamp;
		}

		public function getSignature() {
			return $this->signature;
		}

		public function getCallback() {
			return $this->callback;
		}
}
