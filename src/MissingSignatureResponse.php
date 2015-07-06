 <?php

namespace Zumba\VanillaJsConnect;

class MissingSignatureResponse extends Response {

	protected $error = 'invalid_request';
	//Two spaces intentional. Copied message from original library
	protected $message = 'Missing  signature parameter.';

}
