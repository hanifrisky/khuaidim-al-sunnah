<?php

return [

    'single' => [

        'label' => 'يمسح',

        'modal' => [

            'heading' => 'حذف :label',

            'actions' => [

                'delete' => [
                    'label' => 'يمسح',
                ],

            ],

        ],

        'notifications' => [

            'deleted' => [
                'title' => 'تم حذف البيانات بنجاح',
            ],

        ],

    ],

    'multiple' => [

        'label' => 'حذف المحدد',

        'modal' => [

            'heading' => 'حذف المحدد :label',

            'actions' => [

                'delete' => [
                    'label' => 'يمسح',
                ],

            ],

        ],

        'notifications' => [

            'deleted' => [
                'title' => 'Data berhasil dihapus',
            ],

            'deleted_partial' => [
                'title' => 'Menghapus :count dari :total',
                'missing_authorization_failure_message' => 'Anda tidak mempunyai akses untuk menghapus :count.',
                'missing_processing_failure_message' => ':count tidak dapat dihapus.',
            ],

            'deleted_none' => [
                'title' => 'Gagal menghapus',
                'missing_authorization_failure_message' => 'Anda tidak mempunyai akses untuk menghapus :count.',
                'missing_processing_failure_message' => ':count tidak dapat dihapus.',
            ],

        ],

    ],

];
