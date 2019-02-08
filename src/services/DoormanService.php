<?php
/**
 * Doorman plugin for Craft CMS 3.x
 *
 * This plugin guards the url you either don't want to show or you don't want to hit it too oftern
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2019 Simple Integrated Marketing
 */

namespace simpleteam\doorman\services;

use simpleteam\doorman\Doorman;

use Craft;
use craft\base\Component;

/**
 * @author    Simple Integrated Marketing
 * @package   Doorman
 * @since     1.0.0
 */
class DoormanService extends Component
{
    // Public Methods
    // =========================================================================
    public function findDoorConfigBySlug($slug) {
        $config = Doorman::$plugin->getSettings()->config;
        $door = null;
        foreach ($config as $configRow) {
            if ($configRow['slug']==$slug) {
                $door = $configRow;
            }
        }
        return $door;
    }
}
