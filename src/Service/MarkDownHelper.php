<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkDownHelper
{
    private MarkdownParserInterface $markdownParser;
    private CacheInterface $cache;
    private bool $isDebug;
    private LoggerInterface $markdownLogger;

    public function __construct(
        MarkdownParserInterface $markdownParser,
        CacheInterface $cache,
        LoggerInterface $markdownLogger,
        bool $isDebug
    ) {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        $this->markdownLogger = $markdownLogger;
    }

    public function parse(string $source): string
    {
        if (stripos($source, 'cat') !== false) {
            $this->markdownLogger->info("Meow!");
        }

        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }

        return $this->cache->get('markdown_'.md5($source), fn() => $this->markdownParser->transformMarkdown($source));
    }
}
