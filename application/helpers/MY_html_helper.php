<?php
    function haalJavascriptOp($js)
    {
        return "<script src=\"" . base_url("assets/js/" . $js) . "\"></script>";
    }

    function pasStylesheetAan($css)
    {
        return "<link rel=\"stylesheet\" href=\"" . base_url("assets/css/" . $css) . "\" />";
    }

function toonAfbeelding($afbeelding, $attributen = '')
{
    return "<img src=\"" . geefVolledigeNaam($afbeelding) . "\"" . _stringify_attributes($attributen) . " />";
}

function geefVolledigeNaam($afbeelding)
{
    $CI =& get_instance();
    $CI->load->helper('url');
    return base_url() . $afbeelding;
}
