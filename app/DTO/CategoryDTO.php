<?php

namespace App\DTO;

class CategoryDTO extends DataTransferObject
{
    public string $name;
    public string $description;
    public bool $is_active;
}
