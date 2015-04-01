<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\youtube;


use yii\validators\Validator;
use Yii;

class CodeValidator extends Validator
{
    /**
     * @var bool whether filtering value
     */
    public $urlFilter = true;

    /**
     * @var bool whether validation process should take an api call to ensure that video id is correct
     */
    public $enableApiCall = true;

    /**
     * @var string
     */
    public $urlPattern = 'http://gdata.youtube.com/feeds/api/videos/{video_id}';

    /**
     * @var string the regular expression used to validate the attribute value.
     */
    public $codePattern = '/[A-za-z0-9_-]{11}/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = '{attribute} contains invalid video code.';
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if ($this->urlFilter) {
            $model->$attribute = $this->getCodeFromUrl($model->$attribute);
        }
        parent::validateAttribute($model, $attribute);
    }


    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (is_string($value)) {
            if ($this->enableApiCall) {
                $url = str_replace('{video_id}', $value, $this->urlPattern);
                $headers = get_headers($url);
                if ($headers[0] == '200') {
                    return null;
                }
            }
            if (preg_match($this->codePattern, $value)) {
                return null;
            }
        }
        return [$this->message, []];
    }

    /**
     * @param $url string video url that contains video id
     * @return string|null
     */
    protected function getCodeFromUrl($url)
    {
        $parts = parse_url($url);
        if(isset($parts['query'])){
            parse_str($parts['query'], $qs);
            if(isset($qs['v'])){
                return $qs['v'];
            }else if(isset($qs['vi'])){
                return $qs['vi'];
            }
        }
        if(isset($parts['path'])){
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path)-1];
        }
        if (preg_match($this->codePattern, $url, $match)) {
            return $match[0];
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode(Yii::$app->getI18n()->format($this->message, [
            'attribute' => $model->getAttributeLabel($attribute),
        ], Yii::$app->language), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $condition = "!value.match($this->codePattern)";
        if ($this->skipOnEmpty) {
            $condition .= " && value != ''";
        }
        return "if ($condition) { messages.push($message); };";
    }
} 