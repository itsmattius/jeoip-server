<?php

namespace Jeoip\Server\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class TrustProxies
{
    public function handle(Request $request, Closure $next)
    {
        $proxies = $this->trustedProxies();
        if (!empty($proxies)) {
            Request::setTrustedProxies(
                $proxies,
                Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PROTO
                | Request::HEADER_X_FORWARDED_PORT
            );

            if ($this->remoteIsTrusted($request, $proxies)) {
                $cf = $request->headers->get('CF-Connecting-IP');
                if (is_string($cf) && '' !== $cf) {
                    $request->server->set('REMOTE_ADDR', $cf);
                }
            }
        }

        return $next($request);
    }

    /**
     * @return array<string>
     */
    private function trustedProxies(): array
    {
        $value = trim((string) env('TRUSTED_PROXIES', ''));
        if ('' === $value) {
            return [];
        }
        if ('*' === $value) {
            return ['REMOTE_ADDR'];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * @param array<string> $proxies
     */
    private function remoteIsTrusted(Request $request, array $proxies): bool
    {
        if (['REMOTE_ADDR'] === $proxies) {
            return true;
        }
        $remote = $request->server->get('REMOTE_ADDR');

        return is_string($remote) && IpUtils::checkIp($remote, $proxies);
    }
}
