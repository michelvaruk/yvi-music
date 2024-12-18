<?php

namespace App\Twig\Extension;

use App\Repository\SiteRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Extension\AbstractExtension;

class SiteExtension extends AbstractExtension
{
    public function __construct(private SiteRepository $site, private CacheInterface $cache)
    {
        
    }

    public function getSiteInfo()
    {
        return $this->cache->get('siteInfo', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->site->find(1);
        });
    }
}