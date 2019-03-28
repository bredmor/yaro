# Yaro - Light Extensible Markdown Parser for PHP

Yaro is a Parser and Lexer framework meant for Markdown. By Default, Yaro parses **basic** markdown.

## Installation / Usage


### From Source:
Clone the repository from GitHub or unzip into your vendor directory. Yaro is packaged for [PSR-4](https://www.php-fig.org/psr/psr-4/) autoloading.

### From Composer:
TODO

### Using in your project:

```$php
$yaro = new Yaro();
echo $yaro->parse("Your *markdown* text here.");
```

### Adding a new markdown token to the default lexer:

```$php
$lexer = new bredmor\Yaro\Lexer\DefaultLexer();
$lexer->setToken('/Your PCRE-compat regex here/', function($match) {
    // Any closure, function name or preg_* function compatible replacement string can be used for the 2nd argument
});
$yaro = new Yaro($lexer);
echo $yaro->parse("Your custom markdown text here.");
```

### Extensibility
You can either `extend` the default parser or lexer, or implement `LexerInterface` and `ParserInterface` on your own, custom classes.

Just pass either to constructor when initiating it and it will be used instead of the default.

```$php
$parser = new MyCustomParser();
$yaro = new Yaro(null, $parser); // Using a NULL value for the parser or lexer in the controller will cause Yaro to use the default class.
```

You can also change the parser or lexer of an existing Yaro object at *any* time. This allows you to Inject an already configured Yaro instance and swap contexts on the fly.

```$php
$yaro = new Yaro();
echo $yaro->parse("My markdown string"); // The string is evaluated using the default lexer
$yaro->setLexer($myOtherLexerClass);
echo $yaro->parse("My other markdown string"); // This string is evaluated using the new lexer
```

## Requirements

PHP 7.2 or above.

## Supported Markdown
Yaro's default lexer supports the following markdown:

\*Italic Emphasis\* with asterisks or underscores

\*\*Bold\*\* with asterisks or underscores

\~\~Strikethrough\~\~

\-\-\-\-\- Horizonal Rulers

\#Headings

\>Blockquotes (>, &gt;, |, >> and »)

\`\`\` Code Blocks

\` Inline Code

\*Unordered Lists (*, - and +)

\1.Ordered Lists (any number)

\[Links](http://example.com)

\!\[Embedded Images](link_to_image.png)

## Authors

- Morgan Breden  | [GitHub](https://github.com/bredmor)  | [Twitter](https://twitter.com/bredmor) | <morganbreden@gmail.com>

## Contributing

Pull requests, bug reports and feature requests are welcome.

## License

Composer is licensed under the GPLv3 License - see the [LICENSE](LICENSE) file for details

## Acknowledgements

Yaro is [named after](https://en.wiktionary.org/wiki/%E9%87%8E%E9%83%8E#Japanese) the individual who really wanted me to write another markdown parser specifically for their use case.
