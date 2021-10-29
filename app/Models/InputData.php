<?php


namespace App\Models;

use App\Validators\InputDataValidator;

class InputData
{

    private string $script; // it's for path of the script file
    private string $txtFlag; // it goes for '-i' flag
    private string $txtFile; // for txt file path
    private string $filterFlag; // for '-f' flag
    private string $filter; // goes for filter name 'most-reapeating', 'non-reapeating' and so on
    private array  $paramFlags; // goes for '-L', '-P' and so on flags
    private InputDataValidator $validator;
    private array $availableFilters;
    private array $availableFilterFlags;


    public function __construct(array $input)
    {
        $this->validator = new InputDataValidator();

        $this->availableFilterFlags = $this->validator->getFilterFlags();
        $this->availableFilters = $this->validator->getFilters();

        foreach ($input as $key => $value) {

            switch ($key) {
                case 0:
                    break;
                case 1:
                    $this->validator->txtFlagValidate($value) ? $this->txtFlag = $value : die('Error code: 1');
                    break;
                case 2:
                    $this->validator->txtFileValidate($value) ? $this->txtFile = $value : die('Error code: 2');
                    break;
                case 3:
                    $this->validator->filterFlagValidate($value) ? $this->filterFlag = $value : die('Error code: 3');
                    break;
                case 4:
                    $this->validator->filterValidate($value) ? $this->filter = $value : die('Error code: 3');
                    break;
                case ($key > 4):
                    $this->validator->paramFlagValidate($value) ? $this->paramFlags[] = $value : die('Error code: 4');
                    break;
                default:
                    die('Something went wrong...');
                    break;

            }

        }

        if (count($input) < 6) {
            die('Error code: 4');
        }


    }

    public function getAvailableFilterFlags()
    {
        return $this->availableFilterFlags;
    }

    public function getAvailableFilters()
    {
        return $this->availableFilters;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function getTxtFile()
    {
        return $this->txtFile;
    }

    public function getTxtFlag()
    {
        return $this->txtFlag;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getFilterFlag()
    {
        return $this->filterFlag;
    }

    public function getParamFlags(): array
    {
        return $this->paramFlags;
    }

    public function getValidator(): InputDataValidator
    {
        return $this->validator;
    }


}
