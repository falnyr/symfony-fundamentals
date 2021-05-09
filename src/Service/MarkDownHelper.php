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
    private LoggerInterface $mdLogger;

    public function __construct(
        MarkdownParserInterface $markdownParser,
        CacheInterface $cache,
        LoggerInterface $mdLogger,
        bool $isDebug
    ) {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        $this->mdLogger = $mdLogger;
    }

    public function parse(string $source): string
    {
        if (stripos($source, 'cat') !== false) {
            $this->mdLogger->info("Meow!");
        }

        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }

        return $this->cache->get('markdown_'.md5($source), fn() => $this->markdownParser->transformMarkdown($source));
    }
}
