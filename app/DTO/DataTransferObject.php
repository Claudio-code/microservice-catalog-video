<?php

namespace App\DTO;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject as DataTransferObjectAbstract;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DataTransferObject extends DataTransferObjectAbstract
{
    protected bool $ignoreMissing = true;

    /**
     * @throws UnknownProperties
     *
     * @param array<string, mixed> $parameters
     */
    public function __construct(array $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            unset($parameters[$key]);
            $parameters[$key] = $value;
        }

        parent::__construct($parameters);
    }

    /**
     * @param array<string, mixed> $array
     *
     * @return array<string, mixed>
     */
    protected function parseArray(array $array): array
    {
        $newArray = [];

        foreach (parent::parseArray($array) as $key => $value) {
            if ($value instanceof DateTime) {
                $value = $value->format('Y-m-d H:i:s.u');
            }

            $newArray[$this->camelToSnakeCase((string) $key)] = $value;
        }

        return $newArray;
    }

    private function camelToSnakeCase(string $input): string
    {
        return strtolower(
            preg_replace('/(?<!^)[A-Z]/', '_$0', $input) ?? ''
        );
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws UnknownProperties
     */
    public static function factory(array $data): self
    {
        return new self($data);
    }
}
