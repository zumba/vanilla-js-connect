<?php

namespace Zumba\VanillaJsConnect;

class InvalidOrMissingTimeStampResponse extends Response {

	protected $error = 'invalid_request';

	protected $message = 'The timestamp parameter is missing or invalid.';
}
