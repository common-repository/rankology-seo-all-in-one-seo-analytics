<?php

namespace Rankology\Core\Hooks;

defined('ABSPATH') or exit('Cheatin&#8217; uh?');

interface DeactivationHook {
    public function deactivate();
}
