<?php

return [
    'encoding'      => 'UTF-8',
    'finalize'      => true,
    'ignoreNonStrings' => false,
    'cachePath'     => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    'settings'      => [
        'default' => [
            'HTML.Doctype'                => 'HTML 4.01 Transitional',
            'HTML.Allowed'                => 'div,b,strong,i,em,u,a[href|title|target],ul,ol,li,p,br,span,img[src|alt|height|width],h1,h2,h3,h4,h5,h6,blockquote,pre,code,hr',
            'CSS.AllowedProperties'       => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph'    => true,
            'AutoFormat.RemoveEmpty'      => true,
        ],
        'simple' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'b,strong,i,em,u,a[href|title|target],ul,ol,li,br,span,p',
        ],
        'no-html' => [
            'HTML.Allowed' => '',
        ],
    ],
];
