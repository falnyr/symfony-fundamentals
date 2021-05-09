<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkDownHelper
{
    private MarkdownParserInterface $markdownParser;
    private CacheInterface $cache;

    public function __construct(MarkdownParserInterface $markdownParser, CacheInterface $cache)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
    }

    public function parse(string $source): string
    {
        return $this->cache->get('markdown_'.md5($source), fn() => $this->markdownParser->transformMarkdown($source));
    }
}
