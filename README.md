
# vanilla-js-connect [![Build Status](https://travis-ci.org/zumba/vanilla-js-connect.svg?branch=master)](https://travis-ci.org/zumba/vanilla-js-connect)
Object oriented Vanilla Forums jsConnect implementation for PHP [found here](https://github.com/vanilla/jsConnectPHP).

### Getting Started
First, instantiate a Request, User, and Config object.  
The Config class will throw errors if any arguments are not set. SSO will respond with an Error Response if any arguments for User or Request are missing or incorrect.

      //We store these in an environment file
      $config = new $Config([
        "client_id" => "foo",
        "secret" => "bar",
        "jsTimeout" => 1440
      ]);

      $request = new Request([
          'client_id' => "Get these"
          'timestamp' => "from parsing",
          'signature' => "the url",
          'callback' => "parameters"
      ]);

      $user = new User([
        'name' => "Pull these",
        'photoUrl' => "From",
        'uniqueId' => "Your",
        'email' => "User session"
      ]);

      $sso = new SSO($request, $user, $config);

Once you've created a SSO object, all that is left is generating the response.

    $response = $sso->getResponse();

SSO does all the work of validating the Request. Responses will be created according to the example from the [jsConnect PHP Library](https://github.com/vanilla/jsConnectPHP), and returned as a Response object.

The response has a __toString() method allowing you to

    echo $response;

or you can store the JSON response by casting it to a string

    $response = (string)$sso->getResponse();

And that's it. You'll have the correctly formatted JSON output response.
