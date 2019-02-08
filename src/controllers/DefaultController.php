<?php
/**
 * Doorman plugin for Craft CMS 3.x
 *
 * This plugin guards the url you either don't want to show or you don't want to hit it too oftern
 *
 * @link      https://simple.com.au
 * @copyright Copyright (c) 2019 Simple Integrated Marketing
 */

namespace simpleteam\doorman\controllers;

use simpleteam\doorman\Doorman;

use Craft;
use craft\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author    Simple Integrated Marketing
 * @package   Doorman
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex($slug)
    {
        $door = Doorman::$plugin->doormanService->findDoorConfigBySlug($slug);
        if (!$door) {
            throw new NotFoundHttpException();
        }

        $url = $door['url'];

        $cache = Craft::$app->cache;
        if ($cache->exists(Doorman::CACHE_KEY_PREFIX.$url)) {
            $content = $cache->get(Doorman::CACHE_KEY_PREFIX.$url);
            return $content;
        }

        $content = file_get_contents($url);
        $cache->set(Doorman::CACHE_KEY_PREFIX.$url,$content,$door['cacheSeconds']);
        return $content;
    }

    public function actionFlushCache() {
        $slug = Craft::$app->request->getParam('slug');
        $door = Doorman::$plugin->doormanService->findDoorConfigBySlug($slug);
        if (!$door) {
            throw new NotFoundHttpException();
        }
        $cache = Craft::$app->cache;
        $cache->delete(Doorman::CACHE_KEY_PREFIX.$door['url']);
        Craft::$app->session->setNotice("The cached content for ".$door['name'].' has been flushed');
        return $this->redirectToPostedUrl();
    }


}
