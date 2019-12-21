<?php

namespace RaiderIO;

class Essence
{
    private int $_id;
    private string $_name;

    public function __construct()
    {
        $this->_id = -1;
        $this->_name = '';
    }

    public function setId(int $id): bool
    {
        $this->_id = $id;
        return true;
    }

    public function getId(): string
    {
        return $this->_id;
    }

    public function getName(): string
    {
        return $this->_name;
    }

    public function setName(string $name): bool
    {
        $this->_name = $name;
        return true;
    }
}
