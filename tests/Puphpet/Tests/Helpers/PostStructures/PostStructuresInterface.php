<?php

namespace Puphpet\Tests\Helpers\PostStructures;

interface PostStructuresInterface
{
    public function getDefault();
    public function getBare();
    public function getComplete();
    public function getInvalid();
}
