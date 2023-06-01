<?php

// コンバート用の設定を記述します
// ディレクトリは末尾スラッシュ無し

return [
    'poweramp' => [
        'inputPath'  => '/mnt/d/music/Playlists/Poweramp/In',   // 入力ファイルのベースとなるパス
        'outputPath' => '/mnt/d/music/Playlists/Poweramp/Out',  // 出力ファイルのベースとなるパス
        'extension'  => 'm3u8', // 対象となる拡張子
        'replacePairs' => [
            // str_replace で使用する置換パターン
            'patterns' => [
                'D:\\music\\',
                '\\',
            ],
            'replacements' => [
                'external_sd/Music/',
                '/',
            ],
        ],
    ],
];
