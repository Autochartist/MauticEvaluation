<?php
include __DIR__ . '/../vendor/autoload.php';
use Mautic\Auth\ApiAuth;
use Mautic\MauticApi;

session_start();

//-- PARAMS, hardcoded atm but can also be sent via cmd args
$settings = [
    'userName' => 'mautic@autochartist.com',
    'password' => 'svp3rm4n',
];
$baseUrl = "https://mautic.autochartist.com/";
$fileName = "data.csv";

//-- Initiate the auth object specifying to use BasicAuth as well as the MauticApi object we will be using
$initAuth   = new ApiAuth();
$api        = new MauticApi();
$auth       = $initAuth->newAuth($settings, 'BasicAuth');
$contactFieldsApi = $api->newApi('contactFields', $auth, $baseUrl);

//-- read the file, remove newlines and empty spaces and parse the remaining content in a array of fields, each field containing a label and type property
$fields = prepareFields($fileName);

//-- iterate through each and try to create the field (if not existing)
foreach ($fields as $field) {
    //-- check if field exists already
    $list = $contactFieldsApi->getList($field['label']);
    
    //-- if it does, log a message
    if ($list["total"] != 0) {
        echo PHP_EOL."The specified field name '{$field['label']}' already exists. Skipping.";
    } else {
        //-- otherwise create the field
        $contactFieldsApi->create($field);
        $httpResponseCode = $contactFieldsApi->getResponseInfo()["http_code"];

        //-- check the response to see if successful
        if (in_array($httpResponseCode, [201, 200])) {
            echo PHP_EOL."Field '{$field['label']}' was created successfully. Response code: {$httpResponseCode}";
        } else {
            echo PHP_EOL."There was an error while creating the field '{$field['label']}'. Response code: {$httpResponseCode}";
        }
    }
}

function prepareFields(string $filename): array {
    $csv = array_map('str_getcsv', file($filename));

    $fields = [];
    foreach ($csv as $line) {
        $fields[] = [
            "label" => $line[0],
            "type" => $line[1]
        ];
    }

    return $fields;
}

