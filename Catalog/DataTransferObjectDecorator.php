<?php

namespace Catalog;

abstract class DataTransferObjectDecorator
{
    /** @var array<string, string|bool> */
    private array $data = [];

    /** @param mixed[] $data */
    abstract public static function factory(array $data): self;

    /** @return mixed[] */
    abstract public function getAllData(): array;
}
