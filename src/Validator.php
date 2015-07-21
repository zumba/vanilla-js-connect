<?php

namespace Zumba\VanillaJsConnect;

interface ValidatorInterface {

  public function validate(Request $request, User $user = null, Config $config = null);

}
