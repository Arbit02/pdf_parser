<?php
function parsePDF()
{
    $jsonData = file_get_contents('data.json');
    $data = json_decode($jsonData, true);

    if ($data) {
        $csvFile = fopen('data.csv', 'w');
        fwrite($csvFile, "\xEF\xBB\xBF");
        fputcsv($csvFile, array_keys($data[0]));

        foreach ($data as $row) {
            fputcsv($csvFile, $row);
        }

        fclose($csvFile);
    }
}

function GetPDF()
{

    $url = 'https://minjust.gov.ru/ru/activity/directions/998/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $links = $dom->getElementsByTagName('a');
    $pdf_url = '';
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        if (strpos($href, 'reestr-inostrannyih-agentov') !== false) {
            if (strpos($href, 'http') === false) {
                $href = 'https://minjust.gov.ru' . $href;
            }
            $pdf_url = $href;
            break;
        }
    }
    if ($pdf_url) {
        $file = 'file.pdf';
        $fp = fopen($file, 'w');
        $ch = curl_init($pdf_url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        header('Content-Type: application/pdf');
    }
}

function StartPythonScript() //Запускаем наш скрипт :)
{
    shell_exec('python3 main.py');
}

GetPDF();
StartPythonScript();
parsePDF();

