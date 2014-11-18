<?php

namespace Vivait\CustomerBundle\Entity;

class UsernameFactory {
    public static function fromName(Name $name) {
        return preg_replace('~\P{Xan}++~u', '', sprintf($name->toShortFormat()));
    }
}