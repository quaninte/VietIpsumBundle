<?php
/**
 * Quan MT - Brodev Software
 * www.brodev.com
 */

namespace Brodev\VietIpsumBundle\Ipsum;

use Brodev\VietIpsumBundle\Ipsum\Dictionary;

class Generator
{
    /**
     * @var Dictionary $dictionary
     */
    protected $dictionary;

    protected $sentenceMin;
    protected $sentenceMax;

    protected $commaLengthMin;
    protected $commaLengthMax;

    protected $paragraphMin;
    protected $paragraphMax;


    function __construct(Dictionary $dictionary, $commaLengthMax = 7, $commaLengthMin = 3, $paragraphMax = 12, $paragraphMin = 7, $sentenceMax = 12, $sentenceMin = 4)
    {
        $this->dictionary = $dictionary;
        $this->commaLengthMax = $commaLengthMax;
        $this->commaLengthMin = $commaLengthMin;
        $this->paragraphMax = $paragraphMax;
        $this->paragraphMin = $paragraphMin;
        $this->sentenceMax = $sentenceMax;
        $this->sentenceMin = $sentenceMin;
    }

    /**
     * Generate paragraphs
     * @param $paragraph
     * @return string
     */
    public function generate($paragraph)
    {
        $result = '';
        for ($i = 0; $i < $paragraph; $i++) {
            $length = mt_rand($this->paragraphMin, $this->paragraphMax);
            $result .= $this->generateParagraph($length) . "\n\n";
        }

        return $result;
    }

    /**
     * Generate a paragraph
     * @param $sentences
     * @return string
     */
    protected function generateParagraph($sentences)
    {
        $result = '';

        for ($i = 0; $i < $sentences; $i++) {
            $length = mt_rand($this->sentenceMin, $this->sentenceMax);
            $result .= $this->generateSentence($length);
        }
        $result = trim($result);

        return $result;
    }

    /**
     * Generate a sentence
     * @param int $words
     * @return string
     */
    protected function generateSentence($words)
    {
        $result = '';

        $comma = false;
        for ($i = 0; $i < $words; $i++) {
            if ($i == 0) {
                $cap = true;
            } else {
                $cap = false;
            }

            // comma?
            // only add command if comma is not added, get 0.25 lucky and in comma range
            if (!$comma && $i > $this->commaLengthMin && $i <= $this->commaLengthMax && $this->lucky(0.25)) {
                $comma = true;
                $result .= ',';
            }

            $result .= ' ' . $this->dictionary->choseRandom($cap);
        }

        $result .= '.';

        return $result;
    }

    /**
     * Return true if got lucky
     * @param $percentage
     * @return bool
     */
    protected function lucky($percentage)
    {
        $line = $percentage * 100;
        $number = mt_rand(0, 99);
        if ($number < $line) {
            return true;
        }

        return false;
    }

}
