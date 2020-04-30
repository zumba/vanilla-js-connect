<?php

namespace Zumba\VanillaJsConnect\Contracts;

interface ErrorResponseInterface
{
    /**
     * Response data being returned when and error occurred
     *
     * @return array
     */
    public function responseData() : array;
}
