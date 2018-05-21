<?php

namespace App\Library;

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use TeamTNT\TNTSearch\Support\TokenizerInterface;

class JiebaTokenizer implements TokenizerInterface
{
    public function __construct(array $options = [])
    {
        Jieba::init($options);
        Finalseg::init($options);
    }

    public function tokenize($text, $stopwords = [])
    {
        return is_numeric($text) ? [] : $this->getTokens($text, $stopwords);
    }

    public function getTokens($text, $stopwords = [])
    {
        $text = str_replace(["，","。","、","（","）"], ' ', $text);
        $split = Jieba::cutForSearch($text);
        return $split;
    }

    public function cut($text, $mode = false)
    {
        return Jieba::cut($text, $mode);
    }
}