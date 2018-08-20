<?php

namespace App;

class OutputGenerator {

    public function generate(string $title, string $url, string $output)
    {
        $text = str_replace('{{title}}', $title, $output);
        $text = str_replace('{{url}}', $url, $text);

        return $text;
    }

}
