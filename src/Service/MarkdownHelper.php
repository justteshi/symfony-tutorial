<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

class MarkdownHelper
{
    private $markdown;
    private $cache;
    private $logger;
    private $isDebug;
    /**
     * @var Security
     */
    private $security;

    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache, LoggerInterface $markdownLogger, bool $isDebug, Security $security)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
        $this->security = $security;
    }
    public function parse(string $source): string
    {
        if(stripos($source, 'lorem') !== false) {
            $this->logger->info('Lorem contains here',[
                'user' => $this->security->getUser()
            ]);
        }

        if($this->isDebug) {
            return $this->markdown->transform($source);
        }


        $item = $this->cache->getItem('markdown_'.md5($source));

        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        return $item->get();
    }
}
