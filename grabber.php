<?php
set_time_limit(6000);
header('Content-Type:text/html; charset=utf-8');

class programki {

    private $_curl;
    private $_curlContent;
    private $_file;
    private $_dataAray = array();
    private $_todayProgram = FALSE;
    private $_loadProgram = FALSE;
    private $_configTidy = array(
        'output-xml' => TRUE,
        'input-encoding' => 3,
        'output-encoding' => 3,
        'language' => 'ru');

    public function __construct($url) {
        $this->curlInit($url);
        $this->_curlContent = curl_exec($this->_curl);
        $xpath = $this->getHtmlObj($this->_curlContent);
        $this->setListProgram($xpath);
        $this->curlClose();
        foreach ($this->_dataAray as $key => $value) {
            $this->curlInit($value['patch']);
            unset($this->_dataAray[$key]['patch']);
            $this->_curlContent = curl_exec($this->_curl);
            $xpath = $this->getHtmlObj($this->_curlContent);
            $this->setListFile($xpath, $key);
            $this->curlClose();
        }
        foreach ($this->_dataAray as $key => $value) {
            foreach ($value['file'] as $name => $url) {
                $this->curlInit($url);
                $this->curlHeader();
                $this->_curlContent = curl_exec($this->_curl);
                preg_match('/location\:\s([^\s]+)/', $this->_curlContent, $subject);
                $this->curlClose();
                $this->_dataAray[$key]['file'][$name] = $subject[1];
            }
        }

        if ($this->_loadProgram) {
            foreach ($this->_dataAray as $key => $value) {
                foreach ($value['file'] as $name => $url) {
                    $this->curlInit($url);
                    $this->curlReferel();
                    preg_match('/[^\/]+$/', $url, $name);
                    $this->readFile($name[0]);
                    $this->_curlContent = curl_exec($this->_curl);
                    $this->curlClose();
                    $this->closeFile();
                }
            }
        }
    }

    public function getData() {
        return $this->_dataAray;
    }

    private function strTrim($str, $tip = FALSE) {
        return $tip ? str_replace('/\s+|\n+|\t+|\r+/', ' ', trim($str)) : str_replace('/\n+|\t+|\r+/', '', trim($str));
    }

    private function curlInit($url) {
        $this->_curl = curl_init();
        curl_setopt($this->_curl, CURLOPT_URL, $url);
        curl_setopt($this->_curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0');
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, TRUE);
    }

    private function curlReferel() {
        curl_setopt($this->_curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, TRUE);
    }

    private function curlHeader() {
        curl_setopt($this->_curl, CURLOPT_HEADER, TRUE);
    }

    private function curlClose() {
        curl_close($this->_curl);
    }

    private function readFile($name) {
        $this->_file = fopen($name, "w+");
        curl_setopt($this->_curl, CURLOPT_FILE, $this->_file);
    }

    private function closeFile() {
        fclose($this->_file);
    }

    private function getHtmlObj($htmlObj) {
        $tidy = tidy_parse_string($htmlObj, $this->_configTidy);
        $html = $tidy->html();
        $dom = new DomDocument();
        $dom->loadHTML($html->value);
        return new DomXPath($dom);
    }

    private function setListProgram($xpath) {
        $data = $xpath->query(".//table[2]/tr/td[2]/table[2]/tr/td");
        for ($index = 1; $index < $data->length; $index = $index + 2) {
            $a = $xpath->query(".//table[2]/tr/td[2]/table[2]/tr[" . $index . "]/td[1]/a");
            $div = $xpath->query(".//table[2]/tr/td[2]/table[2]/tr[" . ($index + 1) . "]/td[1]/div");            
            if ($this->_todayProgram) {
                preg_match('/Обновлена:\s(\d+.\d+.\d+)/', $div->item(1)->nodeValue, $date);
                if ($date[1] != date("d.m.Y"))
                    continue;
            }
            $name = $this->strTrim(str_replace('Скачать программу ', '', $a->item(0)->nodeValue));
            $this->_dataAray[$name] = array();
            $this->_dataAray[$name]['patch'] = $this->strTrim($a->item(0)->getAttribute('href'));
            $this->_dataAray[$name]['description'] = $this->strTrim($div->item(0)->nodeValue, TRUE);
            $this->_dataAray[$name]['category'] = $this->strTrim($div->item(1)->getElementsByTagName('a')->item(1)->nodeValue) . ', ' . $this->strTrim($div->item(1)->getElementsByTagName('a')->item(2)->nodeValue);
        }
    }

    private function setListFile($xpath, $key) {
        $this->_dataAray[$key]['developer'] = $this->strTrim($xpath->query(".//table[3]/tr/td[2]/table[1]/tr[1]/td[2]")->item(0)->nodeValue);
        $this->_dataAray[$key]['sistem'] = $this->strTrim($xpath->query(".//table[3]/tr/td[2]/table[1]/tr[2]/td[2]")->item(0)->nodeValue);
        $this->_dataAray[$key]['interface'] = $this->strTrim($xpath->query(".//table[3]/tr/td[2]/table[1]/tr[3]/td[2]")->item(0)->nodeValue);
        $this->_dataAray[$key]['license'] = $this->strTrim($xpath->query(".//table[3]/tr/td[2]/table[1]/tr[4]/td[2]")->item(0)->nodeValue);
        $this->_dataAray[$key]['file'] = array();
        $listFile = $xpath->query(".//table[3]/tr/td[2]/table[2]/tr/td[1]/a");
        foreach ($listFile as $childObj) {
            $name = $this->strTrim(str_replace('Скачать ', '', $childObj->nodeValue));
            $path = $this->strTrim($childObj->getAttribute('href'));
            $this->_dataAray[$key]['file'][$name] = $path;
        }
    }

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>programki</title>
    </head>
    <body>
<?php
echo '<pre>';
$programki = new programki('http://programki.net/');
print_r($programki->getData());
?>
    </body>
</html>