<?php

declare(strict_types=1);

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;


final class DummyTest extends TestCase {

    /**
     * @test
     */
    public function returnEmail(): string {
        $this->assertEquals(1, 1);
        return "d.gashi@noexis.ch";
    }

    /**
     * @test
     * @depends returnEmail
     */
    public function emailCompare($email) {
        $this->assertEquals('d.gashi@noexis.ch', $email);
    }
}