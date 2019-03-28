<?php

namespace bredmor\Yaro\Lexer;

interface LexerInterface {

    /**
     * Bitwise flags
     */
    const NO_HREF = 1;
    const NO_IMAGES = 2;

    const FLAG_TABLE = [
        "1" => "NO_HREF",
        "2" => "NO_IMAGES",
    ];

    /**
     * @param String $text
     * @return String
     * Evaluate all tokens and return expressions
     */
    function tokenize($text): string;

    /**
     * @param Integer $flag
     * @return void
     * Set bitwise flag
     */
    function setFlag($flag): void;

    /**
     * @param Integer $flag
     * @return bool
     * Check bitwise flag
     */
    function checkFlag($flag): bool;
}