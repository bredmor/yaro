<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use bredmor\Yaro\Yaro;

final class InstantiationTest extends TestCase {

    public function testCanInstantiateDefaultClass(): void {
        $yaro = new \bredmor\Yaro\Yaro();
        $this->assertInstanceOf(Yaro::class, $yaro);
    }

    public function testCanInstiatiateClassWithParser(): void {
        $yaro = new \bredmor\Yaro\Yaro(new \bredmor\Yaro\Parser\DefaultParser());
        $this->assertInstanceOf(Yaro::class, $yaro);
    }

    public function testCanInstantiateClassWithLexer(): void {
        $yaro = new \bredmor\Yaro\Yaro(null, new \bredmor\Yaro\Lexer\DefaultLexer());
        $this->assertInstanceOf(Yaro::class, $yaro);
    }
}