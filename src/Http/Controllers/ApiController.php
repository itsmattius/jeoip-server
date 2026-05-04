<?php

namespace Jeoip\Server\Http\Controllers;

use Jeoip\Contracts\Exceptions\IQueryException;
use Jeoip\Contracts\IGeoIPService;
use Laravel\Lumen\Routing\Controller;

class ApiController extends Controller
{
    public function __construct(protected IGeoIPService $goeIPService)
    {
    }

    public function query(?string $ip = null)
    {
        try {
            if ($ip === null) {
                $ip = request()->ip();
            }

            /**
             * @var array{string,mixed}
             */
            $data = $this->goeIPService->query($ip)->jsonSerialize();
            $data['user_agent'] = request()->userAgent();
            $data['hostname'] = \gethostbyaddr($ip);
            $data['status'] = true;

            return $data;
        } catch (IQueryException $e) {
            return response()->json([
                'status' => false,
                'query' => $e->getQuery(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function json(?string $ip = null)
    {
        try {
            if ($ip === null) {
                $ip = request()->ip();
            }

            /**
             * @var array{string,mixed}
             */
            $data = $this->goeIPService->query($ip)->jsonSerialize();
            $data['user_agent'] = request()->userAgent();
            $data['hostname'] = \gethostbyaddr($ip);
            $data['status'] = true;

            return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (IQueryException $e) {
            return response()->json([
                'status' => false,
                'query' => $e->getQuery(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @return string
     */
    public function ip()
    {
        return request()->ip();
    }

    public function country(?string $ip = null)
    {
        try {
            /**
             * @var string
             */
            $ip = $ip ?? request()->ip();
            $data = $this->goeIPService->query($ip)->getCountry();

            return $data;
        } catch (IQueryException $e) {
            return response()->json([
                'status' => false,
                'query' => $e->getQuery(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function countryCode(?string $ip = null)
    {
        try {
            /**
             * @var string
             */
            $ip = $ip ?? request()->ip();
            $data = $this->goeIPService->query($ip)->getCountryCode();

            return $data;
        } catch (IQueryException $e) {
            return response()->json([
                'status' => false,
                'query' => $e->getQuery(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function city(?string $ip = null)
    {
        try {
            /**
             * @var string
             */
            $ip = $ip ?? request()->ip();
            $data = $this->goeIPService->query($ip)->getCity();

            return $data;
        } catch (IQueryException $e) {
            return response()->json([
                'status' => false,
                'query' => $e->getQuery(),
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function asn(?string $ip = null)
    {
        try {
            /**
             * @var string
             */
            $ip = $ip ?? request()->ip();
            $data = $this->goeIPService->query($ip)->getAsn();

            return $data;
        } catch (IQueryException $e) {
            return response()->json([
                'status' => false,
                'query' => $e->getQuery(),
                'message' => $e->getMessage(),
            ]);
        }
    }
}
