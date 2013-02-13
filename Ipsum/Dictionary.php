<?php
/**
 * Quan MT - Brodev Software
 * www.brodev.com
 */

namespace Brodev\VietIpsumBundle\Ipsum;

class Dictionary
{

    /**
     * Store all words
     * @var array $words
     */
    protected $words;

    public function getWords()
    {
        return $this->words;
    }

    /**
     * Chose random word
     * @param bool $cap
     * @return string
     */
    public function choseRandom($cap = false)
    {
        $i = mt_rand(0, count($this->words) - 1);

        $word = $this->words[$i];
        if ($cap) {
            $word = ucfirst($word);
        }

        return $word;
    }

    /**
     * Read dictionary from file
     * @param $filePath
     */
    public function readFromFile($filePath)
    {
        $content = file_get_contents($filePath);
        $this->createFromString($content);
    }

    /**
     * Create dictionary from string
     * @param $str
     */
    protected function createFromString($str)
    {
        $str = $this->cleanContent($str);
        $array = array_unique(explode(' ', $str));
        $this->words = array();
        foreach ($array as $word) {
            if (strlen($word) < 2) {
                continue;
            }
            $this->words[] = $word;
        }
    }

    /**
     * Clean string before being broken into dictionary
     * @param $str
     * @return string
     */
    protected function cleanContent($str)
    {
        // lowercase
        $str = mb_strtolower($str, 'UTF-8');

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', ' ', $str);

        // remove all numbers
        $str = preg_replace('/[0-9]/i', ' ', $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote(' ', '/') . '){2,}/', '$1', $str);

        // Remove delimiter from ends
        $str = trim($str);

        return $str;
    }

}
