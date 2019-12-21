<?php

namespace RaiderIO;

class PageDownloader
{
    private $_ch;
    private string $_url;
    private string $_needsDownload;
    private string $_contentFile;

    private string $_requestHourMin;
    private int $_requestDone;

    const REQUEST_LIMIT = 120;

    public function __construct(string $url, string $statusFile, string $contentFile)
    {
        $this->_ch = null;
        $this->_url = $url;
        $this->_statusFile = $statusFile;
        $this->_contentFile = $contentFile;
        $this->_requestHourMin = date('Hi');
        $this->_requestDone = 0;
    }

    public function needsDownload(): bool
    {
        // var_dump($this->_statusFile);
        if (is_file($this->_statusFile)) {
            $statusContents = file_get_contents($this->_statusFile);

            $value = intval($statusContents);

            // we only hit them once a week per url.
            $timeout = time() - (86400*5);

            if ($value > $timeout) {
                return false;
            }

            // the file has timed out.
            unlink($this->_statusFile);
            unlink($this->_contentFile);
        }
        
        // no status file.
        return true;
    }

    public function downloadPage(): bool
    {
        $currentHourMin = date('Hi');

        // are we on a new minute?
        if ($currentHourMin != $this->_requestHourMin) {
            $this->_requestDone = 0;
            $this->_requestHourMin = $currentHourMin;
        }

        $this->_requestDone++;

        if ($this->_requestDone >= self::REQUEST_LIMIT) {
            $sleepAmt = mt_rand(1, 10);
            echo "  rateLimit sleepAmt($sleepAmt)\n";
            sleep($sleepAmt);
        }

        if ($this->_ch === null) {
            $this->_ch = curl_init();
            
            curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt(
                $this->_ch,
                CURLOPT_USERAGENT,
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3983.2 Safari/537.36'
            );
        }

        
        curl_setopt($this->_ch, CURLOPT_URL, $this->_url);
        //curl_setopt($this->_ch, CURLOPT_VERBOSE , true);
        $urlContents = curl_exec($this->_ch);

        // var_dump($urlContents);

        //curl_close($ch);

        $raw = json_decode($urlContents, true);

        if (is_array($raw)) {
            if (array_key_exists('statusCode', $raw)) {
                $statusCode = intval($raw['statusCode']);
                if ($statusCode == 400) {
                    // api didn't let us download this url.
                    echo "failed to download, please debug url\n";
                    var_dump($this->_url);
                    var_dump($raw);
                    return false;
                }
            }

            $fpc = file_put_contents($this->_contentFile, $urlContents);
            $sfpc = file_put_contents($this->_statusFile, time());

            if ($fpc != false && $sfpc != false) {
                echo "  download - OK!\n";
                return true;
            }
        }

        if (is_file($this->_contentFile)) {
            unlink($this->_contentFile);
        }
        
        if (is_file($this->_statusFile)) {
            unlink($this->_statusFile);
        }

        return false;
    }
}
