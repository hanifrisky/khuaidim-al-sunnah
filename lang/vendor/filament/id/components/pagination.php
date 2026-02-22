<?php

return [

    'label' => 'Navigasi halaman',

    'overview' => '{1} Menampilkan 1 hasil|[2,*] Menampilkan :first sampai :last dari :total hasil',

    'fields' => [

        'records_per_page' => [

            'label' => 'لكل صفحة',

            'options' => [
                'all' => 'الجميع',
            ],

        ],

    ],

    'actions' => [

        'first' => [
            'label' => 'Pertama',
        ],

        'go_to_page' => [
            'label' => 'Ke halaman :page',
        ],

        'last' => [
            'label' => 'Terakhir',
        ],

        'next' => [
            'label' => 'التالي',
        ],

        'previous' => [
            'label' => 'سابق',
        ],

    ],

];
