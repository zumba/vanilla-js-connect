<?php

namespace Zumba\VanillaJsConnect;

class InvalidTimestampResponse extends Response {

	protected $error = 'invalid_request';

	protected $message = 'The timestamp is invalid.';

}
