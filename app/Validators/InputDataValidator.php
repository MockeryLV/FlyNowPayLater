<?php

namespace App\Validators;

class InputDataValidator
{

    private const FILTER_FLAGS = [ // these are allowed filter flags to use
        '-P',
        '-L',
        '-S'
    ];

    private const RESTRICTED_CHARS = [
        " ",
        "\n"
    ];


    private const FILTERS = [
        'non-repeating',
        'least-repeating',   //these are allowed filters to use
        'most-repeating'
    ];


    public function txtFlagValidate(string $txtFlag): bool
    {
        if ($txtFlag === '-i' || $txtFlag === '--input') {
            return true;
        }
        return false;
    }

    public function txtFileValidate(string $txtFile): bool
    {

        if (file_exists($txtFile)) {
            if (!empty(file($txtFile))) {

                $txtArray = str_split(file($txtFile)[0]);

                foreach (self::RESTRICTED_CHARS as $char) {
                    if (in_array($char, $txtArray)) {
                        return false;
                    }
                }

                foreach ($txtArray as $char) {

                    if (ctype_alpha($char) && $char !== strtolower($char)) {
                        return false;
                    }
                    if (is_numeric($char)) {
                        return false;
                    }
                }
                return true;

            } else {
                return false;
            }
        }

        return false;

    }

    public function filterFlagValidate(string $flag): bool
    {
        if ($flag === '-f' || $flag === '--format') {
            return true;
        }
        return false;
    }


    public function filterValidate(string $filter): bool
    {

        if (in_array($filter, self::FILTERS)) {
            return true;
        }
        return false;


    }

    public function paramFlagValidate(string $value): bool
    {
        if (in_array($value, self::FILTER_FLAGS)) {
            return true;
        }
        return false;

    }

    public function getFilterFlags(): array {

        return self::FILTER_FLAGS;

    }

    public function getFilters(): array {

        return self::FILTERS;

    }

}
