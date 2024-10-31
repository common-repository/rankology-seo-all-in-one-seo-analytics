<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class DashboardOption
{
    /**
     * 
     *
     * @return array
     */
    public function getOption()
    {
        return get_option(Options::KEY_OPTION_DASHBOARD);
    }

    /**
     * 
     *
     * @param string $key
     *
     * @return mixed
     */
    public function searchOptionByKey($key)
    {
        $data = $this->getOption();

        if (empty($data)) {
            return null;
        }

        if (! isset($data[$key])) {
            return null;
        }

        return $data[$key];
    }
}
