<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pekerjaan;
use App\Models\User;

class GajiPokok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:gaji-pokok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate gaji pokok freelance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Jakarta');

        DB::beginTransaction();

        try {

            $freelance  = User::select('id', 'name', 'id_role')->where('id_role', 8)->where('id_user', '!=','TK018')->where('id_user', '!=','TK017')->get();

            foreach ($freelance as $data) {
                $array = [
                    'id_user'               => $data->id,
                    'tgl'                   => date('Y-m-d'),
                    'id_jenis_pekerjaan'    => 6,
                    'keterangan'            => 'Gaji Pokok',
                    'fee'                   => 500000,
                    'status'                => 'valid',
                    'created_at'            => now(),
                    'updated_at'            => now(),
                    'created_by'            => 1,
                ];

                $result[] = $array;
            }

            Pekerjaan::insert($result);

            DB::commit();
            //add log
            Log::channel('info')->info('Task Scheduler : ', [
                'success'  => 'Add Gaji Pokok Freelance'
            ]);

            NotificationDiscord('SUKSES : ', 'Add Gaji Pokok Freelance');

        } catch (\Exception $e) {
            DB::rollback();

            //add log
            Log::channel('info')->info('GAGAL : ', [
                'error'  => $e
            ]);

            Log::channel('discord')->info('GAGAL Add Gaji Pokok Freelance : ', [
                'error'  => $e
            ]);
        }
    }
}
