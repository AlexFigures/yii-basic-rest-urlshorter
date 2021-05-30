<?php


namespace app\commands;

class GenerateShortLink
{
    private $url;
    public $generatedHash;

    public function __construct($url)
    {
        $this->url = $url;
        $this->generate();
    }

    protected function generate() {

        $hash = md5(md5($this->url));

        $random = static function ($hash) use (&$random) {
            $rand = mt_rand(0, (strlen($hash)-8));
            return $rand >= 8 ? $rand : $random($hash);
        };

        $offset =  $random($hash);
        $this->generatedHash = substr($hash, $offset, 8);
        return $this->generatedHash;
    }
}