<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FileKesekretariat;
use Illuminate\Support\Facades\Storage;

class BackfillFileDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:backfill-details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfills file_size and file_extension for existing FileKesekretariat records.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting backfill of file details...');

        $filesToUpdate = FileKesekretariat::whereNotNull('dokumen_file')
            ->where(function ($query) {
                $query->whereNull('file_size')
                      ->orWhereNull('file_extension');
            })
            ->get();

        if ($filesToUpdate->isEmpty()) {
            $this->info('No records found requiring backfill.');
            return Command::SUCCESS;
        }

        $this->withProgressBar($filesToUpdate, function ($file) {
            $filePath = 'documents/' . $file->dokumen_file;

            if (Storage::disk('public')->exists($filePath)) {
                try {
                    $fileSize = Storage::disk('public')->size($filePath);
                    $fileExtension = pathinfo($file->dokumen_file, PATHINFO_EXTENSION);

                    $file->update([
                        'file_size' => $fileSize,
                        'file_extension' => $fileExtension,
                    ]);
                    // $this->info("Updated file: {$file->nama_dokumen}");
                } catch (\Exception $e) {
                    $this->error("Error updating file {$file->nama_dokumen}: " . $e->getMessage());
                }
            } else {
                $this->warn("File not found in storage for record: {$file->nama_dokumen} (ID: {$file->id})");
            }
        });

        $this->info("\nBackfill complete.");
        return Command::SUCCESS;
    }
}