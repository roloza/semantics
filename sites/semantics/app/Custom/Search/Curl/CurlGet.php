<?php
namespace App\Custom\Search\Curl;

class CurlGet
{
    private $url;
    private $options;

    /**
     * @param string $url     Request URL
     * @param array  $options cURL options
     */
    public function __construct($url, array $options = [])
    {
        $this->url = $url;
        $this->options = $options;
    }

    /**
     * Get the response
     * @return string
     * @throws \RuntimeException On cURL error
     */
    public function __invoke(array $parameters)
    {
        $ch = \curl_init($this->url . '?' . http_build_query($parameters));

        foreach ($this->options as $key => $val) {
            \curl_setopt($ch, $key, $val);
        }

        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_POST, 0);

        $response = \curl_exec($ch);
        $error    = \curl_error($ch);
        $errno    = \curl_errno($ch);

        if (\is_resource($ch)) {
            \curl_close($ch);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }


        return $response;
    }
}
?>

