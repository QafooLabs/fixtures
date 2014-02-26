<?php

namespace Qafoo\Fixtures;

class Globber
{
    public function glob($pattern)
    {
        return glob($pattern);
    }
}
