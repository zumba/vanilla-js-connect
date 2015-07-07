<?php

namespace Zumba\VanillaJsConnect;

class ClientIDMissingResponse extends Response
{

    private $error = 'invalid_client';
    private $message = 'The client_id parameter is missing.';

}
