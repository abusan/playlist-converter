<?php

// ディレクトリは末尾スラッシュ無し

return [
    'poweramp' => [
        'inputPath' => '/mnt/d/doc/music/Playlists/Poweramp/In',
        'outputPath' => '/mnt/d/doc/music/Playlists/Poweramp/Out',
        'extension' => 'm3u8',
        'replacePairs' => [
            'patterns' => [
                'D:\\doc\\music\\',
                '\\',
            ],
            'replacements' => [
                'external_sd/Music/',
                '/',
            ],
        ],
    ],
];
