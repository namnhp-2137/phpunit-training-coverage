<?php

namespace Tests\C0;

use App\UsernameValidation;
use PHPUnit\Framework\TestCase;

class UsernameValidationTest extends TestCase
{
    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))), 1, $length);
    }

    public function test_give_minimum_username_then_false_and_show_message()
    {
        $usernameValidation = new UsernameValidation();

        $this->assertFalse($usernameValidation->isValid(''));
        $this->assertEquals('Minimum length is ' . UsernameValidation::MIN_LENGTH, $usernameValidation->getMessage());
    }

    public function test_give_maximum_username_then_false_and_show_message()
    {
        $usernameValidation = new UsernameValidation();
        $username = $this->generateRandomString(UsernameValidation::MAX_LENGTH + 1); //get string always greater then MAX_LENGTH

        $this->assertFalse($usernameValidation->isValid($username));
        $this->assertEquals('Maximum length is ' . UsernameValidation::MAX_LENGTH, $usernameValidation->getMessage());
    }

    public function test_username_have_dash_at_begin_or_end_then_false_and_show_message()
    {
        $usernameValidation = new UsernameValidation();
        $username = $this->generateRandomString(floor(UsernameValidation::MAX_LENGTH / 2)); //get string allow in length
        $username .= '-'; //add dash to test valid

        $this->assertFalse($usernameValidation->isValid($username));
        $this->assertEquals('- cannot appear at begin or end of name', $usernameValidation->getMessage());
    }

    public function test_username_have_multiple_dash_at_same_place_then_false_and_show_message()
    {
        $usernameValidation = new UsernameValidation();
        $username = $this->generateRandomString(floor(UsernameValidation::MAX_LENGTH / 2)); //get string allow in length
        $username .= '--'; //add multiple dash to test valid

        $this->assertFalse($usernameValidation->isValid($username));
        $this->assertEquals('Only single - is allowed', $usernameValidation->getMessage());
    }

    public function test_username_have_character_not_allow_then_false_and_show_message()
    {
        $usernameValidation = new UsernameValidation();
        $username = $this->generateRandomString(floor(UsernameValidation::MAX_LENGTH / 2)); //get string allow in length
        $username .= '@'; //add character not allow test valid

        $this->assertFalse($usernameValidation->isValid($username));
        $this->assertEquals('Invalid character. Use only letters, digits and -', $usernameValidation->getMessage());
    }

    public function test_username_id_valid()
    {
        $usernameValidation = new UsernameValidation();
        $username = $this->generateRandomString(floor(UsernameValidation::MAX_LENGTH / 2)); //get string allow in length

        $this->assertTrue($usernameValidation->isValid($username));
    }
}
