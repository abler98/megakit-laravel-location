<?php

namespace MegaKit\Laravel\Location\Resolvers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\LocationNotFoundException;
use MegaKit\Laravel\Location\Models\Location;

abstract class SubdomainLocationResolver implements LocationResolver
{
    /**
     * @var string
     */
    private $domain;

    /**
     * SubdomainLocationResolver constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->domain = parse_url($config['url'], PHP_URL_HOST);
    }

    /**
     * @param Request $request
     * @return Location|null
     * @throws LocationNotFoundException
     */
    public function resolve(Request $request): ?Location
    {
        if ($this->isSubdomainRequest($request)) {
            if ($location = $this->findBySubdomain($request, $this->getRequestSubdomain($request))) {
                return $location;
            } else {
                throw new LocationNotFoundException('Can\'t resolve location from sub-domain');
            }
        }

        return null;
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isSubdomainRequest(Request $request): bool
    {
        $position = strpos($request->getHost(), $this->domain);

        return $position !== false && $position !== 0;
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getRequestSubdomain(Request $request): string
    {
        $host = $request->getHost();

        return substr($host, 0, strpos($host, $this->domain) - 1);
    }

    /**
     * @param Request $request
     * @param string $subdomain
     * @return Location|null
     */
    protected abstract function findBySubdomain(Request $request, string $subdomain): ?Location;
}
