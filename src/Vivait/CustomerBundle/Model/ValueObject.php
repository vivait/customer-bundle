<?php

namespace Vivait\CustomerBundle\Model;

interface ValueObject
{
    /**
     * Converts an value object in to it's scalar representation
     * @return mixed
     */
    public function toForm();
}