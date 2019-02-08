<?php
/**
 * Doorman plugin for Craft CMS 3.x
 *
 * This plugin guards the url you either don't want to show or you don't want to hit it too oftern
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2019 Simple Integrated Marketing
 */

namespace simpleteam\doorman;

use simpleteam\doorman\services\DoormanService as DoormanServiceService;
use simpleteam\doorman\utilities\DoormanUtility as DoormanUtilityUtility;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\services\Utilities;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Doorman
 *
 * @author    Simple Integrated Marketing
 * @package   Doorman
 * @since     1.0.0
 *
 * @property  DoormanServiceService $doormanService
 */
class Doorman extends Plugin
{
    // Static Properties
    // =========================================================================
    const CACHE_KEY_PREFIX = 'doorman_cache_';
    /**
     * @var Doorman
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        Craft::setAlias('@doorman-api-base','/_api/doorman');

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules[Craft::getAlias('@doorman-api-base').'/<slug:{slug}>'] = 'doorman/default';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
            }
        );

        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = DoormanUtilityUtility::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // Copy the example config if there isn't one
                    $configPath = Craft::$app->config->getConfigFilePath('doorman');
                    if (!file_exists($configPath)) {
                        $content = file_get_contents(__DIR__.'/config.example.php');
                        file_put_contents($configPath, $content);
                    }
                }
            }
        );

        Craft::info(
            Craft::t(
                'doorman',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

    }

    protected function createSettingsModel()
    {
        $config = Craft::$app->config->getConfigFromFile('doorman');
        return new DoormanSettings(['config'=>$config]);
    }


}
