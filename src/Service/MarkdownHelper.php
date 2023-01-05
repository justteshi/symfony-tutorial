<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private $markdown;
    private $cache;
    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;

    }
    public function parse(string $source): string
    {
        $item = $this->cache->getItem('markdown_'.md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        return $item->get();
    }
}
