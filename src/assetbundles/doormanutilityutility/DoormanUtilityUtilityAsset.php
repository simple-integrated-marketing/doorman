<?php
/**
 * Doorman plugin for Craft CMS 3.x
 *
 * This plugin guards the url you either don't want to show or you don't want to hit it too oftern
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2019 Simple Integrated Marketing
 */

namespace simpleteam\doorman\assetbundles\doormanutilityutility;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Simple Integrated Marketing
 * @package   Doorman
 * @since     1.0.0
 */
class DoormanUtilityUtilityAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@simpleteam/doorman/assetbundles/doormanutilityutility/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/DoormanUtility.js',
        ];

        $this->css = [
            'css/DoormanUtility.css',
        ];

        parent::init();
    }
}
