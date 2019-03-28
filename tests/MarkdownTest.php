<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class MarkdownTest extends TestCase {

    public function testParsesItalics(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse('*test*');
        $this->assertEquals('<em>test</em>', $output);
    }


    public function testParsesBold(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse('**test**');
        $this->assertEquals('<strong>test</strong>', $output);
    }

    public function testParsesStrikethrough(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse('~~test~~');
        $this->assertEquals('<s>test</s>', $output);
    }

    public function testParsesHorizonalRule(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse("\n-----");
        $this->assertEquals("\n<hr />", $output);
    }

    public function testParsesHeaders(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse("\n#test\n test\n###test");
        $this->assertEquals("\n<h1>test</h1>\n test\n<h3>test</h3>", $output);
    }

    public function testParsesBlockquote(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse("test\n>test\ntest");
        $this->assertEquals("test\n<blockquote>test</blockquote>\ntest", $output);
    }

    public function testParsesCodeBlock(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse("test```test```");
        $this->assertEquals("test<pre><code>test</code></pre>", $output);
    }

    public function testParsesInlineCode(): void {
        $yaro = new bredmor\Yaro\Yaro();
        $output = $yaro->parse('test`test`test');
        $this->assertEquals('test<code>test</code>test', $output);
    }

    public function testParsesUnorderedLists(): void {
        $yaro = new \bredmor\Yaro\Yaro();
        $output = $yaro->parse("\n-test1\n+test2\n*test3");
        $this->assertEquals("\n<ul><li>test1</li><li>test2</li><li>test3</li></ul>", $output);
    }

    public function testParsesOrderedLists(): void {
        $yaro = new \bredmor\Yaro\Yaro();
        $output = $yaro->parse("\n1.test1\n6.test2\n9.test3");
        $this->assertEquals("\n<ol><li>test1</li><li>test2</li><li>test3</li></ol>", $output);
    }

}