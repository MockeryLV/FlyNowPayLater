<?php

use App\Validators\InputDataValidator;
use PHPUnit\Framework\TestCase;

/*
 * this is unit tests for InputDataValidator
 */

class InputDataValidatorTest extends TestCase
{

    public function testTxtFlagValidate(){

        $validator = new InputDataValidator();

        $result = $validator->txtFlagValidate('-i');
        $this->assertEquals(true, $result);
        $result = $validator->txtFlagValidate('--input');
        $this->assertEquals(true, $result);
        $result = $validator->txtFlagValidate('-input');
        $this->assertEquals(false, $result);

    }

    public function testTxtFileValidate(){

        $validator = new InputDataValidator();

        $result = $validator->txtFileValidate('not_a_real_file.txt');
        $this->assertEquals(false, $result);
        $result = $validator->txtFileValidate('files/01.txt');
        $this->assertEquals(false, $result);
        $result = $validator->txtFileValidate('files/02.txt');
        $this->assertEquals(false, $result);

    }


    public function testFilterFlagValidate(){

        $validator = new InputDataValidator();

        $result = $validator->filterFlagValidate('-f');
        $this->assertEquals(true, $result);
        $result = $validator->filterFlagValidate('---f');
        $this->assertEquals(false, $result);
        $result = $validator->filterFlagValidate('--format');
        $this->assertEquals(true, $result);

    }

    public function testFilterValidate(){

        $validator = new InputDataValidator();

        $result = $validator->filterValidate('most-repeating');
        $this->assertEquals(true, $result);
        $result = $validator->filterValidate('least-repeating');
        $this->assertEquals(true, $result);
        $result = $validator->filterValidate('non-repeating');
        $this->assertEquals(true, $result);
        $result = $validator->filterValidate('something-repeating');
        $this->assertEquals(false, $result);

    }

    public function testParamFlagValidate(){

        $validator = new InputDataValidator();

        $result = $validator->paramFlagValidate('-P');
        $this->assertEquals(true, $result);
        $result = $validator->paramFlagValidate('-L');
        $this->assertEquals(true, $result);
        $result = $validator->paramFlagValidate('-S');
        $this->assertEquals(true, $result);
        $result = $validator->paramFlagValidate('P');
        $this->assertEquals(false, $result);
        $result = $validator->paramFlagValidate('-s');
        $this->assertEquals(false, $result);


    }


}