<?php
namespace bredmor\Yaro;

use bredmor\Yaro\Lexer\DefaultLexer;
use bredmor\Yaro\Lexer\LexerInterface;
use bredmor\Yaro\Parser\DefaultParser;
use bredmor\Yaro\Parser\ParserInterface;

class Yaro {

    private $lexer;
    private $parser;

    public function __construct(LexerInterface $lexer = null, ParserInterface $parser = null) {
        if($parser === null) {
            $this->parser = new DefaultParser();
        }

        if($lexer === null) {
            $this->lexer = new DefaultLexer();
        }
    }

    /**
     * Parse provided markdown.
     *
     * @param String $text
     * @return string|null
     */
    public function parse($text): string {
        return $this->parser->parseDocument($text);
    }

    /**
     * Set a new Lexer
     *
     * @param LexerInterface $lexer
     */
    public function setLexer(LexerInterface $lexer): void {
        $this->lexer = $lexer;
    }

    /**
     * Set a new Parser
     *
     * @param ParserInterface $parser
     */
    public function setParser(ParserInterface $parser): void {
        $this->parser = $parser;
    }
}