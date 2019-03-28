<?php

namespace bredmor\Yaro\Parser;

use bredmor\Yaro\Lexer\LexerInterface;

interface ParserInterface {

    /**
     * ParserInterface constructor.
     * @param LexerInterface $lexer
     */
    function __construct(LexerInterface $lexer);

    /**
     * @param Integer $flag
     * @return void
     */
    function setFlag($flag): void;

    /**
     * @param String $text
     * @return String
     */
    function parseDocument($text): string;

}