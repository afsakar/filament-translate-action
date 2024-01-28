<?php

namespace Afsakar\FilamentTranslateAction\Helpers;

use Illuminate\Support\Facades\Http;

/**
 * Main class GoogleTranslate
 */
class GoogleTranslate
{
    /**
     * Retrieves the translation of a text
     *
     * @param  string  $source
     *                          Original language of the text on notation xx. For example: es, en, it, fr...
     * @param  string  $target
     *                          Language to which you want to translate the text in format xx. For example: es, en, it, fr...
     * @param  string  $text
     *                        Text that you want to translate
     * @return string a simple string with the translation of the text in the target language
     */
    public static function translate($source, $target, $text)
    {
        // Request translation
        $response = self::requestTranslation($source, $target, $text);

        // Clean translation
        $translation = self::getSentencesFromJSON($response);

        return $translation;
    }

    /**
     * Internal function to make the request to the translator service
     *
     * @internal
     *
     * @param  string  $source
     *                          Original language taken from the 'translate' function
     * @param  string  $target
     *                          Target language taken from the ' translate' function
     * @param  string  $text
     *                        Text to translate taken from the 'translate' function
     * @return string The response of the translation service in JSON format
     */
    protected static function requestTranslation($source, $target, $text)
    {
        if (strlen($text) >= 5000) {
            throw new \Exception('Maximum number of characters exceeded: 5000');
        }

        // Google translate URL
        $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&dt=t';

        $response = Http::asForm()
            ->post($url, [
                'sl' => $source,
                'tl' => $target,
                'q' => $text,
            ]);

        return $response->body();
    }

    /**
     * Dump of the JSON's response in an array
     *
     * @param  string  $json
     *                        The JSON object returned by the request function
     * @return string A single string with the translation
     */
    protected static function getSentencesFromJSON($json)
    {
        $sentencesArray = json_decode($json, true);
        $sentences = '';

        if (! $sentencesArray || ! isset($sentencesArray[0])) {
            throw new \Exception('Google detected unusual traffic from your computer network, try again later (2 - 48 hours)');
        }

        foreach ($sentencesArray[0] as $s) {
            $sentences .= isset($s[0]) ? $s[0] : '';
        }

        return $sentences;
    }
}
