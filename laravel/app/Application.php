<?php

namespace App;

class Application extends \Illuminate\Foundation\Application
{
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }
}
