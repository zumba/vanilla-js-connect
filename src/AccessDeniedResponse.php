<?php

namespace Zumba\VanillaJsConnect;

class AccessDeniedResponse extends Response {

	protected $error = 'access_denied';

	protected $message = 'Signature invalid.';


}
