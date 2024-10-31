<?php

namespace Rankology\Services\Options;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

use Rankology\Constants\Options;

class ToggleOption {
    /**
     * 
     *
     * @return array
     */
    public function getOption() {
        return get_option(Options::KEY_TOGGLE_OPTION);
    }

    /**
     * 
     *
     * @param string $key
     *
     * @return mixed
     */
    public function searchOptionByKey($key) {
        $data = $this->getOption();

        if (empty($data)) {
            return null;
        }

        $keyComposed = sprintf('toggle-%s', $key);
        if ( ! isset($data[$keyComposed])) {
            return null;
        }

        return $data[$keyComposed];
    }

    /**
     * 
     *
     * @return string
     */
    public function getToggleLocalBusiness() {
        return $this->searchOptionByKey('local-business');
    }

    public function getToggleGoogleNews(){
        return $this->searchOptionByKey('news');
    }

    public function getToggleInspectUrl(){
        return $this->searchOptionByKey('inspect-url');
    }

    /**
     * 
     *
     * @return string
     */
    public function getToggleAi(){
        return $this->searchOptionByKey('ai');
    }

    /**
     * 
     *
     * @return string
     */
    public function getToggleWhiteLabel(){
        return $this->searchOptionByKey('white-label');
    }
}
