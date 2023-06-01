<?php

return [

    "constants" => [

        "enable_status" => [
            "desable" => 0,
            "enable" => 1,
        ],
        "visible_status" => [
            "desable" => 0,
            "enable" => 1,
        ],
        "publish_status" => [
            "published" => 0,
            "pending" => 1,
            "waiting" => 2,
            "unconfirmed" => 3,
            "draft" => 4,
            "trash" => 5
        ]

    ],

    "entities" => [

        "articles" => [
            "model" => "",
            "fillable" => [],
            "relations" => [],
            "fields" => [
                "title" => ["type" => "text", "props" => [ "label" => "title" ]],
                "content" => ["type" => "textarea", "props" => [ "label" => "content" ]],
                "status" => ["type" => "select", "options" => [
                    "type" => "static", // static | constant | relation
                    "items" => [
                        //[ "label" => "email", "value" => "email" ]
                        "email" => "email",
                        "pass" => "pass"
                    ]
                ]]
            ]
        ]

    ],


];
