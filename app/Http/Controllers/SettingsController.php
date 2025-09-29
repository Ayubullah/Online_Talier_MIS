<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        // Get system information
        $systemInfo = [
            'app_name' => config('app.name'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_name' => config('database.connections.mysql.database'),
            'app_env' => config('app.env'),
            'timezone' => config('app.timezone'),
            'disk_free_space' => $this->formatBytes(disk_free_space(storage_path())),
        ];

        // Get database statistics
        $dbStats = [
            'database_size' => $this->getDatabaseSize(),
            'total_tables' => $this->getTotalTables(),
            'total_records' => $this->getTotalRecords(),
        ];

        return view('settings.index', compact('systemInfo', 'dbStats'));
    }

    public function backupDatabase()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = storage_path('backups/' . $filename);

            // Create backups directory if it doesn't exist
            if (!File::exists(storage_path('backups'))) {
                File::makeDirectory(storage_path('backups'), 0755, true);
            }

            // Get database configuration
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Create backup command
            $command = "mysqldump --host={$host} --port={$port} --user={$username} --password={$password} {$database} > {$backupPath}";
            
            // Execute backup
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => __('Failed to create database backup')
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => __('Database backup created successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error creating backup: ') . $e->getMessage()
            ]);
        }
    }

    public function backupHistory()
    {
        try {
            $backups = [];
            $backupPath = storage_path('backups');

            if (File::exists($backupPath)) {
                $files = File::files($backupPath);
                
                foreach ($files as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                        $backups[] = [
                            'filename' => basename($file),
                            'created_at' => date('Y-m-d H:i:s', filemtime($file)),
                            'size' => $this->formatBytes(filesize($file)),
                            'download_url' => route('settings.download-backup', basename($file))
                        ];
                    }
                }

                // Sort by creation date (newest first)
                usort($backups, function($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
            }

            return response()->json($backups);

        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    public function downloadBackup($filename)
    {
        $backupPath = storage_path('backups/' . $filename);

        if (!File::exists($backupPath)) {
            abort(404);
        }

        return response()->download($backupPath);
    }

    public function deleteBackup($filename)
    {
        try {
            $backupPath = storage_path('backups/' . $filename);

            if (!File::exists($backupPath)) {
                return response()->json([
                    'success' => false,
                    'message' => __('Backup file not found')
                ]);
            }

            File::delete($backupPath);

            return response()->json([
                'success' => true,
                'message' => __('Backup deleted successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error deleting backup: ') . $e->getMessage()
            ]);
        }
    }

    public function uploadBackup(Request $request)
    {
        try {
            $request->validate([
                'backup_file' => 'required|file|mimes:sql|max:102400' // Max 100MB
            ]);

            $file = $request->file('backup_file');
            $originalName = $file->getClientOriginalName();
            
            // Generate a unique filename with timestamp
            $filename = 'uploaded_' . date('Y-m-d_H-i-s') . '_' . $originalName;
            $backupPath = storage_path('backups/' . $filename);

            // Create backups directory if it doesn't exist
            if (!File::exists(storage_path('backups'))) {
                File::makeDirectory(storage_path('backups'), 0755, true);
            }

            // Move uploaded file to backups directory
            $file->move(storage_path('backups'), $filename);

            return response()->json([
                'success' => true,
                'message' => __('Backup file uploaded successfully'),
                'filename' => $filename
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error uploading backup: ') . $e->getMessage()
            ]);
        }
    }

    public function restoreBackup(Request $request)
    {
        try {
            $request->validate([
                'backup_filename' => 'required|string'
            ]);

            $filename = $request->input('backup_filename');
            $backupPath = storage_path('backups/' . $filename);

            if (!File::exists($backupPath)) {
                return response()->json([
                    'success' => false,
                    'message' => __('Backup file not found')
                ]);
            }

            // Get database configuration
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Create restore command
            $command = "mysql --host={$host} --port={$port} --user={$username} --password={$password} {$database} < {$backupPath}";
            
            // Execute restore
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => __('Failed to restore database backup')
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => __('Database restored successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error restoring backup: ') . $e->getMessage()
            ]);
        }
    }

    public function clearCache()
    {
        try {
            // Clear various caches
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return response()->json([
                'success' => true,
                'message' => __('All caches cleared successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error clearing cache: ') . $e->getMessage()
            ]);
        }
    }

    public function optimizeApp()
    {
        try {
            // Optimize the application
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return response()->json([
                'success' => true,
                'message' => __('Application optimized successfully')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Error optimizing application: ') . $e->getMessage()
            ]);
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function getDatabaseSize()
    {
        try {
            $result = DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'size'
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [config('database.connections.mysql.database')]);

            return $result[0]->size . ' MB';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    private function getTotalTables()
    {
        try {
            $result = DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [config('database.connections.mysql.database')]);

            return $result[0]->count;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getTotalRecords()
    {
        try {
            $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
            $totalRecords = 0;

            foreach ($tables as $table) {
                $count = DB::table($table)->count();
                $totalRecords += $count;
            }

            return $totalRecords;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
