<?php

namespace MegaKit\Laravel\Location\Providers;

use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;
use Geocoder\Location as GeocoderLocation;
use Geocoder\Query\GeocodeQuery;
use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;
use MegaKit\Laravel\Location\Location;
use MegaKit\Laravel\Location\Models\City;
use MegaKit\Laravel\Location\Models\Country;
use MegaKit\Laravel\Location\Models\Point;

class GeocoderLocationProvider implements LocationGeoProvider
{
    /**
     * @var Geocoder
     */
    private $geocoder;

    /**
     * GeocoderLocationProvider constructor.
     * @param Geocoder $geocoder
     */
    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * @param string $ip
     * @return Location|null
     */
    public function getByIp(string $ip): ?Location
    {
        $response = $this->geocoder->geocodeQuery(GeocodeQuery::create($ip))->get();

        /** @var GeocoderLocation|null $result */
        $result = $response->first(function (GeocoderLocation $location) {
            return $location->getLocality() !== null || $location->getCountry() !== null;
        });

        if (null === $result) {
            return null;
        }

        $location = new Location();
        $location->setCountry($this->getCountryFromResult($result));
        $location->setCity($this->getCityFromResult($result));

        return $location;
    }

    /**
     * @param GeocoderLocation $location
     * @return City|null
     */
    private function getCityFromResult(GeocoderLocation $location): ?City
    {
        if (null === $location->getLocality()) {
            return null;
        }

        $city = new City();
        $city->setName($location->getLocality());

        if ($coordinates = $location->getCoordinates()) {
            $city->setCoordinates(new Point($coordinates->getLatitude(), $coordinates->getLongitude()));
        }

        return $city;
    }

    /**
     * @param GeocoderLocation $location
     * @return Country
     */
    private function getCountryFromResult(GeocoderLocation $location): Country
    {
        if (null === $location->getCountry()) {
            return null;
        }

        $country = new Country();

        $country->setName($location->getCountry()->getName());
        $country->setCode($location->getCountry()->getCode());

        return $country;
    }
}
