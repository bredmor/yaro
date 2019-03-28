<?php

namespace bredmor\Yaro\Parser;

use bredmor\Yaro\Lexer\DefaultLexer;
use bredmor\Yaro\Lexer\LexerInterface;

class DefaultParser implements ParserInterface {

    protected $lexer;

    /**
     * Parser constructor.
     * @param LexerInterface|null $lexer
     */
    public function __construct(LexerInterface $lexer = null) {
        $this->lexer = $lexer;

        if($lexer === null) {
            $this->lexer = new DefaultLexer();
        }
    }

    /**
     * @param Integer $flag
     * return void
     */
    public function setFlag($flag): void {
        $this->lexer->setFlag($flag);
    }

    /**
     * @param String $text
     * @return string|null
     * The default implementation has nothing to do here since the default lexer is just a simple find/replace
     * More involved methods might do more...
     * e.g. have the lexer classify DOM Elements and return them to the Parser for rendering
     */
    public function parseDocument($text): string {
        return $this->lexer->tokenize($text);
    }

}