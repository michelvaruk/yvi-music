<?php

namespace App\Twig\Extension;

use App\Repository\PartnerRepository;
use App\Repository\ProjectRepository;
use App\Repository\SiteRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Extension\AbstractExtension;

class SiteExtension extends AbstractExtension
{
    public function __construct(
        private SiteRepository $site,
        private PartnerRepository $partner,
        private ProjectRepository $project,
        private CacheInterface $cache)
    {
        
    }

    public function getSiteInfo()
    {
        return $this->cache->get('siteInfo', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->site->find(1);
        });
    }

    public function getPartners()
    {
        return $this->cache->get('partners', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->partner->findAll();
        });
    }
    public function getProjects()
    {
        return $this->cache->get('projects', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->project->findBy(['active' => true]);
        });
    }
}