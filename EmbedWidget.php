<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\youtube;

use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Widget for creating YouTube embedded players
 */
class EmbedWidget extends \yii\base\Widget
{
    /**
     * @var string video id
     */
    public $code;

    /**
     * @var array parameters of embedded player
     */
    public $playerParameters;

    /**
     * @var string url pattern for video content
     */
    public $embedPattern = 'https://www.youtube.com/embed/{video_id}';

    /**
     * @var array options that will be passed to [[Html::tag()]]
     */
    public $iframeOptions;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->code === null) {
            throw new InvalidConfigException('EmbedWidget::code must be set');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $url = str_replace('{video_id}', $this->code, $this->embedPattern);
        if (!empty($this->playerParameters)) {
            $url .= '?' . http_build_query($this->playerParameters);
        }
        $options = array_merge(['src' => $url], $this->iframeOptions);
        echo Html::tag('iframe', '', $options);
    }
}
