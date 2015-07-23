<?php

namespace Zumba\VanillaJsConnect;

interface ValidatorInterface
{
    /**
     * Interface for validators. Returns a Response object or nothing
     *
     * @param  Request $request
     * @param  User  $user
     * @param  Config  $config
     * @return Response
     */
    public function validate(Request $request, User $user = null, Config $config = null);
}
