<?php
$data = [
    'server' => [
        'items' => [
            'php' => [
                'label' => 'PHP',
                'services' => [
                    
                        'PHP Basic',
                        'PHP Yii2',
                        'PHP Laravel',
                        'PHP Symfony',
                        'PHP Cake',
                        'PHP Zend'
                    
                ],
            ],
            'python' => [
                'label' => 'Python',
                'services' => [
                    'Python Basic',
                    'Python Django',
                    'Python Flask',
                    'Python Pyramid'
                ]
            ]
        ],
        'label' => 'Server-Side'
    ],
    'client' => [
        'items' => [
            'javascript' => [
                'label' => 'JavaScript',
                'services' => [
                    'Ecmascript 6',
                    'VueJS'
                ]
            ],
            'android' => [
                'label' => 'Android',
                'services' => [
                    'Java Basic',
                    'Android SDK'
                ]
            ],
            'ios' => [
                'label' => 'iOS',
                'services' => [
                    'Swift Basic',
                    'Cocoa Framework'
                ]
            ]
        ],
        'label' => 'Client-Side'
    ]
];

$template = <<<HTML
<h1>Предлагаемые услуги:</h1>
    <ul class="nav nav-tabs" role="tablist">
       {{tab}}
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab-{{index}}" role="tab" aria-controls="home" aria-selected="true">{{label}}</a>
            </li>
        {{/tab}}
    </ul>
    <div class="tab-content">
        {{content}}
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="home-tab">
                <div class="card d-inline-block" style="width: 18rem;">
                    <img class="card-img-top" src="https://dummyimage.com/250/000000/ffffff" alt="{{title}}">
                    <div class="card-body">
                        <h5 class="card-title">{{title}}</h5>
                        <p class="card-text">
                        <ul class="list-group list-group-flush">
                            {{services}}
                                <li class="list-group-item">{{service-title}}</li>
                            {{/services}}
                        </ul>
                        </p>
                        <a href="#" class="btn btn-primary">Записаться</a>
                    </div>
                </div>
            </div>
        {{/content}}
    </div>
HTML
;

$mass = [
    'simvolOpen' => '{{',
    'simvolClose' => '}}',
    'tab' => 'label'
];

function searchPlaseholder($simvolOpen,$simvolClose, $template)
{
    $result = preg_match('/'.$simvolOpen.'(.*?)'.$simvolClose.'/s',$template, $mathes);
return($mathes);

}
 
$mas = searchPlaseholder('{{tab}}', '{{\/tab}}', $template);

function replaceTab($mas,$data)
{
    $i = 1;
    $str = $mas[1];
    $newString = "";
    foreach ($data  as $key => $value) {
        $str = preg_replace('/{{index}}/', $i, $mas[1]);
        $str =  preg_replace('/{{label}}/', $value['label'], $str);
        $i++;
        $newString.= $str;
    }
    return $newString;
}
$tabMas = replaceTab($mas, $data);



$content = searchPlaseholder('{{content}}', '{{\/content}}', $template);



function replaceContent($mas,$data)
{

    $str = $mas;
    $newString = "";
    $newContent = "";
    foreach ($data  as $key => $value) {
      
        foreach ($value['items'] as $key => $value) {
$title = preg_replace('/{{title}}/', $key, $str);
$service = searchPlaseholder('{{services}}', '{{\/services}}', $title);
 $stringService = "";
for ($i = 0; $i < count($value['services'] ); $i++){
    
    $stringService.= preg_replace('/{{service-title}}/', $value['services'][$i], $service[1]);

}
          $newContent.= preg_replace('/{{services}}(.*?){{\/services}}/s', $stringService, $title);
        }


    }
    return $newContent;

    
}
$stringContent = replaceContent($content[1],$data);
echo $tabMas.''.$stringContent;