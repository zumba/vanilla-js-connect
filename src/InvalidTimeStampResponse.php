<?php

namespace Zumba\VanillaJsConnect;

class InvalidTimeStampResponse extends Response {

	protected $error = 'invalid_request';

	protected $message = 'The timestamp is invalid.';

}
