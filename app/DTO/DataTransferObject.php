<?php

namespace App\DTO;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject as DataTransferObjectAbstract;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DataTransferObject extends DataTransferObjectAbstract
{
    private const REGEX_CAMEL_TO_CASE = '/(?<!^)[A-Z]/';
    private const REPLACE_CAMEL_TO_CASE = '_$0';
    protected bool $ignoreMissing = true;

    /**
     * @param array<string, mixed> $parameters
     * @throws UnknownProperties
     *
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
        $formattedArray = [];
        $parsedArray = parent::parseArray($array);
        foreach ($parsedArray as $key => $value) {
            $keyFormatted = $this->camelToSnakeCase((string) $key);
            $formattedArray[$keyFormatted] = $this->formatDateTimeValues($value);
        }

        return $formattedArray;
    }

    private function formatDateTimeValues(mixed $value): mixed
    {
        return match ($value instanceof DateTime) {
            true => $value->format('Y-m-d H:i:s.u'),
            default => $value,
        };
    }

    private function camelToSnakeCase(string $input): string
    {
        $inputFiltered = preg_replace(
                pattern: self::REGEX_CAMEL_TO_CASE,
                replacement: self::REPLACE_CAMEL_TO_CASE,
                subject: $input,
            ) ?? '';

        return strtolower(string: $inputFiltered);
    }
}
