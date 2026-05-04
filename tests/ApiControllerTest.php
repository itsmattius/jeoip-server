<?php

namespace Tests;

class ApiControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $cityDb = config('geoip.databases.city');
        $asnDb = config('geoip.databases.asn');
        if (!is_string($cityDb) || !is_file($cityDb) || !is_string($asnDb) || !is_file($asnDb)) {
            $this->markTestSkipped('GeoLite2 MMDB files not available; place them under storage/geoip/.');
        }
    }

    public function testQuery(): void
    {
        $this->json('GET', route('ip.info', ['ip' => '1.1.1.1']))
            ->seeJsonContains(['status' => true])
            ->seeJsonStructure([
                'countryCode', 'subnet', 'country', 'country_eu',
                'region', 'city', 'asn', 'asn_org',
                'latitude', 'longitude', 'zipcode', 'timezone',
                'user_agent', 'hostname', 'status',
            ]);
        $this->assertResponseStatus(200);

        $this->json('GET', route('ip.info', ['ip' => '2001:4860:4860::8888']))
            ->seeJsonContains(['status' => true])
            ->seeJsonStructure([
                'countryCode', 'subnet', 'country', 'country_eu',
                'region', 'city', 'asn', 'asn_org',
                'latitude', 'longitude', 'zipcode', 'timezone',
                'user_agent', 'hostname', 'status',
            ]);
    }

    public function testIp(): void
    {
        $this->get(route('ip.ip'));
        $this->assertResponseStatus(200);
    }

    public function testCountry(): void
    {
        $this->get(route('ip.country', ['ip' => '1.1.1.1']));
        $this->assertResponseStatus(200);

        $this->get(route('ip.country', ['ip' => '2001:4860:4860::8888']));
        $this->assertResponseStatus(200);
    }

    public function testCountryCode(): void
    {
        $this->get(route('ip.countryCode', ['ip' => '1.1.1.1']));
        $this->assertResponseStatus(200);

        $this->get(route('ip.countryCode', ['ip' => '2001:4860:4860::8888']));
        $this->assertResponseStatus(200);
    }

    public function testCity(): void
    {
        $this->get(route('ip.city', ['ip' => '1.1.1.1']));
        $this->assertResponseStatus(200);

        $this->get(route('ip.city', ['ip' => '2001:4860:4860::8888']));
        $this->assertResponseStatus(200);
    }

    public function testAsn(): void
    {
        $this->get(route('ip.asn', ['ip' => '1.1.1.1']));
        $this->assertResponseStatus(200);

        $this->get(route('ip.asn', ['ip' => '2001:4860:4860::8888']));
        $this->assertResponseStatus(200);
    }
}
