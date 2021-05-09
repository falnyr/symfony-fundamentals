<?php

namespace App\Twig;

use App\Service\MarkDownHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MarkdownExtension extends AbstractExtension
{
    private MarkDownHelper $markDownHelper;

    public function __construct(MarkDownHelper $markDownHelper)
    {
        $this->markDownHelper = $markDownHelper;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('parse_markdown', [$this, 'parseMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function parseMarkdown($value)
    {
        return $this->markDownHelper->parse($value);
    }
}
