<?php

namespace App\Controllers;

use App\Models\StandingModel;
use App\Utils\Response;

include 'simple_html_dom.php';


class CrawlerController extends Controller {

    public function simpleHTMLDOM() {
        $html = file_get_html('https://telegrafi.com/');
        $lajmet = $html->find('div[class="col-sm-24 fokuslista"]', 0);

        $lajmet_array = $lajmet->find('div[class="row fokusArticle"]');
        $titles = array();

        foreach ($lajmet_array as $la) {
//            $titles[] = $la->find('strong[class="lineClamp lineClamp-4-5em"]', 0)->plaintext;
            $titles[] = $la->find('a[class="fa fa-twitter"]', 0)->{'data-title'};
        }

        foreach ($titles as $t) {
            echo "\n";
            echo "[+] " . $t . "\n";
        }
    }

    public function xpath_standings() {
//        $url = 'https://www.el-pl.ch/erste-liga/erste-liga-classic/spielbetrieb-erste-liga-classic.aspx';
//        $doc = new DOMDocument();
//        @$doc->loadHTML(file_get_contents($url));
//
//        $tables = [
//            "ctl01_ctl12_MatchcenterMaster_ctl01_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl01_tbRangliste",
//            "ctl01_ctl12_MatchcenterMaster_ctl03_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl03_tbRangliste",
//            "ctl01_ctl12_MatchcenterMaster_ctl05_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl05_tbRangliste"
//        ];
//
//        $html_content = '';
//
//        foreach ($tables AS $header => $data) {
//            $table = $doc->getElementById($data)->childNodes;
//            $table_title = $doc->getElementById($header);
//
//            $html_content .= "<h2>$table_title->textContent</h2>";
//            $html_content .= "<table style='border: 1px solid black; border-collapse: collapse'><tbody>";
//
//            foreach ($table AS $t) {
//                $tds = $t->childNodes;
//                $html_content .= "<tr>";
//
//                foreach($tds AS $td) {
//                    $html_content .= "<td style='border: 1px solid black;'>".$td->textContent."</td>";
//                }
//                $html_content .= "</tr>";
//            }
//            $html_content .= "</tbody></table><br>";
//        }
//        (new Response($html_content))->send();
    }

    public function standings() {
        $html_content = '';

        $html = file_get_html('https://www.el-pl.ch/erste-liga/erste-liga-classic/spielbetrieb-erste-liga-classic.aspx');

        $tables = [
            "ctl01_ctl12_MatchcenterMaster_ctl01_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl01_tbRangliste",
            "ctl01_ctl12_MatchcenterMaster_ctl03_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl03_tbRangliste",
            "ctl01_ctl12_MatchcenterMaster_ctl05_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl05_tbRangliste"
        ];

        foreach ($tables as $header => $data) {
            $table_title = $html->find('#' . $header, 0)->find('h4', 0)->plaintext;

            $html_content .= "<h2>$table_title</h2>";
            $html_content .= "<table style='border: 1px solid black; border-collapse: collapse'><tbody>";

            $table = $html->find('#' . $data, 0);

            if ($table == null) continue;

            $table_row = $table->find('tr');

            foreach ($table_row as $tr) {
                $html_content .= "<tr>";
                $html_content .=    "<td>" . $tr->find('.ranCrang', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCteam', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCsp', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCs', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCu', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCn', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCtg', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCdp', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCtdf', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . $tr->find('.ranCpt', 0)->plaintext . "</td>";
                $html_content .= "</tr>";
            }

            $html_content .= "</tbody></table><br><style>td {border: 1px solid black;}</style>";
        }

        $response = new Response($html_content);
        $response->send();
    }

    public function results() {
        $html_content = '';
        $html = file_get_html('https://www.el-pl.ch/erste-liga/erste-liga-classic/spielbetrieb-erste-liga-classic.aspx');

        $tables = [
            "ctl01_ctl12_MatchcenterMaster_ctl00_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl00_tbResultate",
            "ctl01_ctl12_MatchcenterMaster_ctl02_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl02_tbResultate",
            "ctl01_ctl12_MatchcenterMaster_ctl04_pHeader" => "ctl01_ctl12_MatchcenterMaster_ctl04_tbResultate"
        ];

        foreach ($tables as $header => $data) {
            $table_title = $html->find('#' . $header, 0)->find('h4', 0)->plaintext;

            $html_content .= "<h2>$table_title</h2>";
            $html_content .= "<table style='border: 1px solid black; border-collapse: collapse'><tbody>";

            $table = $html->find('#' . $data, 0);

            $results = $table->find('a[class=list-group-item]');

            foreach ($results as $r) {
                $html_content .= "<tr>";
                $html_content .=    "<td>" . $r->find('.teamA', 0)->plaintext . "</td>";
                $html_content .=    "<td> - </td>";
                $html_content .=    "<td>" . $r->find('.teamB', 0)->plaintext . "</td>";
                $html_content .=    "<td>" . ($r->find('.torA', 0) !== null ? $r->find('.torA', 0)->plaintext : 'N/A') . "</td>";
                $html_content .=    "<td> - </td>";
                $html_content .=    "<td>" . ($r->find('.torB', 0) !== null ? $r->find('.torB', 0)->plaintext : 'N/A') . "</td>";
                $html_content .= "</tr>";
            }

            $html_content .= "</tbody></table><br><style>td {border: 1px solid black;}</style>";
        }

        $response = new Response($html_content);
        $response->header("Content-Type: text/html")->send();
    }

    public function homepage() {
        $content = file_get_html('https://www.el-pl.ch/erste-liga/organisation-el/vereine-erste-liga/verein-1l.aspx/v-1751/');

        $title = $content->find('#ctl01_ctl10_VereinMasterObject_ctl01_pHeader', 0)->plaintext;
        $table = $content->find('#ctl01_ctl10_VereinMasterObject_ctl01_tbResultate', 0);

        $html_content = "<h2>$title</h2>";

        for ($i = 0; $i < count($table->childNodes()); $i++) {
            $child = $table->childNodes($i);

            if ($child->hasClass('sppTitel')) {
                $html_content .= "<h3>$child->plaintext</h3>";
            } else {
                $dataRow = $child->find('.row.spiel');

                $html_content .= "<table style='border: 1px solid black; border-collapse: collapse'><tbody>";
                foreach ($dataRow as $dr) {
                    $html_content .= "<tr>";
                    $html_content .=    "<td>" . $dr->find('.time', 0)->plaintext . "</td>";
                    $html_content .=    "<td>" . $dr->find('.teams', 0)->plaintext . "</td>";

                    if ($dr->find('.goals', 0) != null AND $dr->find('.goals', 0) != null) {
                        $html_content .= "<td>" . $dr->find('.goals', 0)->find('.torA', 0)->plaintext . "</td>";
                        $html_content .= "<td> : </td>";
                        $html_content .= "<td>" . $dr->find('.goals', 0)->find('.torB', 0)->plaintext . "</td>";
                    }
                    $html_content .= "</tr>";
                }
                $html_content .= "</table></tbody><style>td {border: 1px solid black;}</style>";
            }
        }
        $response = new Response($html_content);
        $response->send();
    }

    public function worldometers() {
        $html = file_get_html('https://www.worldometers.info/coronavirus/');

        $table = $html->find('#main_table_countries_today', 0);
        $tbody = $table->find('tbody', 0);

        $data = array();

        for ($i = 0; $i < count($tbody->childNodes()); $i++) {
            if (!isset($tbody->childNodes($i)->attr['data-continent'])) {
                $data[] = [
                    'Country' => $tbody->childNodes($i)->childNodes(1)->plaintext,
                    'Total Cases' => implode(explode(',', $tbody->childNodes($i)->childNodes(2)->plaintext)),
                    'New Cases' => $tbody->childNodes($i)->childNodes(3)->plaintext,
                    'Total Deaths' => $tbody->childNodes($i)->childNodes(4)->plaintext,
                    'New Deaths' => $tbody->childNodes($i)->childNodes(5)->plaintext,
                    'Total Recovered' => $tbody->childNodes($i)->childNodes(6)->plaintext,
                    'New Recovered' => $tbody->childNodes($i)->childNodes(7)->plaintext,
                    'Active Cases' => $tbody->childNodes($i)->childNodes(8)->plaintext,
                ];
            }
        }
        send($data);
    }
}