
# vanilla-js-connect [![Build Status](https://travis-ci.org/zumba/vanilla-js-connect.svg?branch=master)](https://travis-ci.org/zumba/vanilla-js-connect)
Object oriented Vanilla Forums jsConnect implementation for PHP

### Get Started
First, instantiate a Request, User, and Config object.

      //We store these in an environment file
      $configParams = [
        "client_id" => "foo",
        "secret" => "bar",
        "jsTimeout" => 1440
      ];

      $config = new Config($configParams);

      $request = new Request([
          'client_id' => "Get these"
          'timestamp' => "from parsing",
          'signature' => "the url",
          'callback' => "parameters"
      ]);

      $userParams = [
        'name' => "Pull these",
        'photoUrl' => "From",
        'uniqueId' => "Your",
        'email' => "User session"
      ];

      $user = new User($userParams);

      $sso = new SSO($request, $user, $config);

Once you've created a SSO object, all that is left is generating the response.

    $response = $sso->getResponse();

This returns either a Response object or one of its children Error Responses.


The response has a __toString() method allowing you to

    echo $resposne;

or you can store the JSON response by casting it to a string

    $response = (string)$sso->getResponse();

And that's it. You'll have the correctly formatted JSON output response.
