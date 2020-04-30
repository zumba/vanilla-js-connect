<?php

namespace Zumba\VanillaJsConnect\Contracts;

interface VanillaUser
{
    /**
     * Get user unique identifier
     *
     * @return string
     */
    public function getUid() : string;

    /**
     * Get the name
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail() : string;

    /**
     * Get the photo url
     *
     * @return string
     */
    public function getPhotoUrl() : string;
}
