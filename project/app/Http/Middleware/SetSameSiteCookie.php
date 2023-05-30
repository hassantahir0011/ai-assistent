<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class SetSameSiteCookie
{
    /**
     * Sets the cookie policy.
     *
     * Enables SameSite none and Secure cookies on:
     *
     * - Chrome v67+
     * - Safari on OSX 10.14+
     * - iOS 13+
     * - UCBrowser 12.13+
     *
     * @return null
     */
    public function handle($request, Closure $next)
    {
        if ($this->checkSameSiteNoneCompatible()) {
            config([
                'session.secure'    => true,
                'session.same_site' => 'none',
            ]);
        }
        return $next($request);
    }


    /**
     * Checks to see if the current browser session should be
     * using the SameSite=none cookie policy.
     *
     * @return bool
     */
    private function checkSameSiteNoneCompatible()
    {
        $compatible = true;

        $this->agent = new Agent();

        $browser = $this->getBrowserDetails();
        $platform = $this->getPlatformDetails();

        if ($this->agent->browser() == 'Chrome' && $browser['float'] < 67) {
            $compatible = false;
        }

        if ($this->agent->is('iOS') && $platform['float'] < 13) {
            $compatible = false;
        }

        if ($this->agent->is('OS X') &&
            ($this->agent->browser() == 'Safari' && !$this->agent->is('iOS')) &&
            $platform['float'] < 10.15
        ) {
            $compatible = false;
        }

        if ($this->agent->browser() == 'UCBrowser' &&
            $browser['float'] < 12.132
        ) {
            $compatible = false;
        }

        return $compatible;
    }

    /**
     * Returns details about the current web browser.
     *
     * @return array
     */
    private function getBrowserDetails()
    {
        $version = $this->agent->version($this->agent->browser(), Agent::VERSION_TYPE_FLOAT);

        return [
            'float' => ($version ?: 0),
        ];
    }

    /**
     * Returns details about the current operating system.
     *
     * @return array
     */
    private function getPlatformDetails()
    {
        $version = $this->agent->version($this->agent->platform(), Agent::VERSION_TYPE_FLOAT);

        return [
            'float' => ($version ?: 0),
        ];
    }

}
