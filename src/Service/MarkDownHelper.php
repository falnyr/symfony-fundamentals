<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkDownHelper
{
    private MarkdownParserInterface $markdownParser;
    private CacheInterface $cache;
    private bool $isDebug;

    public function __construct(
        MarkdownParserInterface $markdownParser,
        CacheInterface $cache,
        bool $isDebug
    ) {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        dump($isDebug);
    }

    public function parse(string $source): string
    {
        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }

        return $this->cache->get('markdown_'.md5($source), fn() => $this->markdownParser->transformMarkdown($source));
    }
}
