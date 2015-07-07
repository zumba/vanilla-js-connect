<?php

namespace Zumba\VanillaJsConnect;

class InvalidOrMissingTimeStampResponse extends Response
{
		/**
		 *  Holds the error type. Corresponds with the array key in toArray
		 *
		 * @var string
		 */
    protected $error = 'invalid_request';
		/**
		 * Error Message
		 * 
		 * @var string
		 */
    protected $message = 'The timestamp parameter is missing or invalid.';
}
