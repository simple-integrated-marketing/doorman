<?php
/**
 * Doorman plugin for Craft CMS 3.x
 *
 * This plugin guards the url you either don't want to show or you don't want to hit it too oftern
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2019 Simple Integrated Marketing
 */

namespace simpleteam\doorman\utilities;

use craft\helpers\UrlHelper;
use simpleteam\doorman\Doorman;
use simpleteam\doorman\assetbundles\doormanutilityutility\DoormanUtilityUtilityAsset;

use Craft;
use craft\base\Utility;

/**
 * Doorman Utility
 *
 * @author    Simple Integrated Marketing
 * @package   Doorman
 * @since     1.0.0
 */
class DoormanUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('doorman', 'Doorman');
    }

    /**
     * @inheritdoc
     */
    public static function id(): string
    {
        return 'doorman-doorman-utility';
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@simpleteam/doorman/assetbundles/doormanutilityutility/dist/img/DoormanUtility-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(DoormanUtilityUtilityAsset::class);

        $config = Doorman::$plugin->getSettings()->config;

        $doors = array_map(function($configRow){
            return [
                'name' => $configRow['name'],
                'url' => $configRow['url'],
                'slug' => $configRow['slug'],
                'cacheSeconds' => $configRow['cacheSeconds'],
                'maskUrl' => UrlHelper::siteUrl(Craft::getAlias('@doorman-api-base/'.$configRow['slug']))
            ];
        },$config);

        return Craft::$app->getView()->renderTemplate(
            'doorman/_components/utilities/DoormanUtility_content',
            [
                'doors' => $doors,
                'configPath' => Craft::$app->config->getConfigFilePath('doorman')
            ]
        );
    }
}
