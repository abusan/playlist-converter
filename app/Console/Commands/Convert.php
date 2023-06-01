<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use SplFileObject;

class Convert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert {source} {dest?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    protected string $mode = '';
    protected string $source = '';
    protected string $dest = '';

    protected string $extension = '';
    protected string $sourceDir = '';
    protected string $destDir = '';

    protected array $patterns = [];
    protected array $replacements = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->source = $this->argument('source') ?? $this->source;
        $this->dest = $this->argument('dest') ?? $this->source;

        $this->sourceDir = config('converter.' . $this->mode . '.inputPath') . '/' . $this->source;
        $this->destDir = config('converter.' . $this->mode . '.outputPath') . '/' . $this->dest;

        $this->patterns = config('converter.' . $this->mode . '.replacePairs.patterns');
        $this->replacements = config('converter.' . $this->mode . '.replacePairs.replacements');

        $this->extension = config('converter.' . $this->mode . '.extension');

        echo 'mode=' . $this->mode . PHP_EOL;
        echo 'source=' . $this->source . PHP_EOL;
        echo 'dest=' . $this->dest . PHP_EOL;

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->sourceDir));
        foreach ($iterator as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            if ($fileInfo->isDir()) continue;

            $file = new SplFileObject($fileInfo->getPathname(), 'r');

            if ($file->isDir()) continue;
            if ($file->getExtension() !== $this->extension) continue;

            $buf = '';
            while (!$file->eof()) {
                $line = $file->fgets();
                $encoding = mb_detect_encoding($line, 'ASCII,JIS,UTF-8,CP51932,SJIS-win', true);
                $line = mb_convert_encoding($line, 'UTF-8', $encoding);

                // 空行の削除
                if (empty($line)) continue;

                // コメント行の削除
                if (mb_strpos($line, '#EXT', 0, $encoding) !== false) continue;

                // パスの置換
                $line = str_replace($this->patterns, $this->replacements, $line);

                $buf .= $line;
            }
            $file = null;

            // 出力先の生成
            if (!file_exists($this->destDir)) mkdir($this->destDir, 0777, true);

            // 出力
            $outputFile = new SplFileObject($this->destDir . '/' . $fileInfo->getBasename(), 'w');
            $outputFile->fwrite($buf);

            echo 'output:' . $this->destDir . '/' . $fileInfo->getBasename() . PHP_EOL;
        }
    }
}
