<?php
namespace bredmor\Yaro\Lexer;

use bredmor\Yaro\Exception\MarkDownException;

class DefaultLexer implements LexerInterface  {

    /**
     * @var Integer
     * Bitwise flags
     */
    protected $flags;

    /**
     * @var array Always-available replacement tokens
     */
    protected static $tokens = array (
        '/(^|\s)(\*\*|__)(.*?)\2/'              => '\1<strong>\3</strong>',              // Bold
        '/(^|\s)(\*|_)(.*?)\2/'                 => '\1<em>\3</em>',                      // Italics
        '/\~\~(.*?)\~\~/'                       => '<s>\1</s>',                         // Strikethrough
        '/\n-{5,}/'                             => "\n<hr />",                          // HR
        '/(?:\n|^)(#+)(.*)/'                    => 'self::header',                      // H1-H6
        '/\n(?:\>|&gt;|\||>>|"|\x{00BB})(.*)/'  => 'self::blockquote',                  // Blockquotes
        '/(?:`{3})(.*?)(?:`{3})/'               => '<pre><code>\1</code></pre>',        // Codeblock
        '/`(.*?)`/'                             => '<code>\1</code>',                   // Inline Code
        '/\n[\*\-\+]([^\*\-\+])(.*)/'           => 'self::ul',                          // Unordered Lists
        '/\n[0-9]+\.(.*)/'                      => 'self::ol',                          // Ordered Lists
        // Hacky fixes for multiline elements
        '/<\/blockquote><blockquote>/'          => '<br />',
        '/<\/ul>\s?<ul>/'                       => '',
        '/<\/ol>\s?<ol>/'                       => ''
    );

    public function tokenize($text): string {
        $this->enableElements();

        foreach(self::$tokens as $token => $replace) {
            if(is_callable($replace)) { // is_callable instead of method_exists so we can support anonymous functions
                $text = preg_replace_callback($token, $replace, $text);
            } else {
                $text = preg_replace($token, $replace, $text);
            }
        }

        return $text;
    }

    public function setFlag($flag): void {
        if(!array_key_exists($flag, self::FLAG_TABLE)) {
            trigger_error(sprintf("Invalid flag \"%s\" set in %s::%s. It will be ignored.", $flag, __CLASS__, __FUNCTION__), E_USER_NOTICE);
        }

        $this->flags = $this->flags | $flag;
    }

    public function checkFlag($flag): bool {
        return (($this->flags & $flag) == $flag);
    }

    /**
     * @param String $token Valid regular expression to match
     * @param String|Callable $rule Replacement for the matched token - either a string with optional PCRE replacement characters
     * or a callable function such as a class member or anonymous expression
     * @throws MarkDownException
     */
    public function setToken($token, $rule): void {
        try {
            preg_match($token, '');
        } catch (\Throwable $exception) {
            throw new MarkDownException(sprintf("Token provided to %s:%s not a valid regular expression.", __CLASS__, __FUNCTION__));
        }

        self::$tokens[$token] = $rule;
    }

    /**
     * enableElements
     * Check for flags that disable certain elements and handle those tokens accordingly
     */
    protected function enableElements(): void {
        if(!$this->checkFlag(self::NO_HREF)) {
            // Links
            self::$tokens['/[^!]\[([^\]]+)\]\((?:javascript:)?([^\)]+)\)/'] = '<a href="\2">\1</a>';
        }

        if(!$this->checkFlag(self::NO_IMAGES)) {
            // Images
            self::$tokens['/!\[([^\[]+)\]\(([^\)]+)\)/'] = '<img src="\2" alt="\1">';
        }
    }

    /**
     * @param $match
     * @return string
     * Render <h1>-<h6>
     */
    protected static function header($match): string {
        $level = strlen($match[1]);
        return sprintf("\n<h%d>%s</h%d>", $level, $match[2], $level);
    }

    /**
     * @param $match
     * @return string
     * Render <blockquote>
     */
    protected static function blockquote($match): string {
        return sprintf ("\n<blockquote>%s</blockquote>", $match[1]);
    }

    /**
     * @param $match
     * @return string
     * Render <ul>
     */
    protected static function ul($match): string {
        return sprintf("\n<ul><li>%s%s</li></ul>", $match[1], $match[2]);
    }

    /**
     * @param $match
     * @return string
     * Render <ol>
     */
    protected static function ol($match): string {
        return sprintf("\n<ol><li>%s</li></ol>", $match[1]);
    }

}