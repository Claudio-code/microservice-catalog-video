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
        parent::__construct(array_filter(
            array: $parameters,
            callback: fn (mixed $value) => !empty($value),
            mode: ARRAY_FILTER_USE_KEY,
        ));
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
            $keyFormatted = $this->camelToSnakeCase((string) $key);
            $valueFormatted = match ($value instanceof DateTime) {
                true => $value->format('Y-m-d H:i:s.u'),
                default => $value,
            };

            $newArray[$keyFormatted] = $valueFormatted;
        }

        return $newArray;
    }

    private function camelToSnakeCase(string $input): string
    {
        return strtolower(
            preg_replace('/(?<!^)[A-Z]/', '_$0', $input) ?? ''
        );
    }
}
