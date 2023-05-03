<?php

namespace App\Console\Commands;

use App\Models\Data_transaksi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Pekerjaan;

class ImportGaji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:import-gaji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Gaji Freelance ke Laba Rugi';

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

        $tgl_awal    = date('Y-m-26', strtotime('-2 month', strtotime(date('Y-m-01'))));
        $tgl_akhir   = date('Y-m-25', strtotime('-1 month', strtotime(date('Y-m-01'))));

        DB::beginTransaction();

        try {

            $freelance  = User::select('id', 'name', 'id_role')->where('id_role', 8)->where('id_user', '!=','TK018')->where('id_user', '!=','TK017')->get();

            foreach ($freelance as $items) {

                $hitung   = DB::table('pekerjaan')
                    ->selectRaw('sum(fee) as total')
                    ->where('status', 'valid')
                    ->where('tgl', '>=', $tgl_awal)
                    ->where('tgl', '<=', $tgl_akhir)
                    ->where('id_user', $items->id)
                    ->first();

                if ($hitung->total) {
                    $gaji   =   $hitung->total;
                } else {
                    $gaji   =   0;
                }

                //Record Salary & Hutang Biaya 
                $no_transaksi   = No_transaksi(date('Y-m-25', strtotime('-1 month', strtotime(date('Y-m-01')))));

                Data_transaksi::create([
                    'no_transaksi'      => $no_transaksi,
                    'tanggal'           => date('Y-m-25', strtotime('-1 month', strtotime(date('Y-m-01')))),
                    'keterangan'        => 'Gaji Freelance ' . $items->name,
                    'nominal'           => $gaji,
                    'id_register'       => null,
                    'id_account'        => '62',
                    'DK'                => 'D',
                    'id_temp'           => null,
                    'ekstra'            => ''
                ]);

                Data_transaksi::create([
                    'no_transaksi'      => $no_transaksi,
                    'tanggal'           => date('Y-m-25', strtotime('-1 month', strtotime(date('Y-m-01')))),
                    'keterangan'        => 'Gaji Freelance ' . $items->name,
                    'nominal'           => $gaji,
                    'id_register'       => null,
                    'id_account'        => '17',
                    'DK'                => 'K',
                    'id_temp'           => null,
                    'ekstra'            => ''
                ]);


                //Record Hutang Biaya & Bank
                $no_transaksi2   = No_transaksi(date('Y-m-d'));

                Data_transaksi::create([
                    'no_transaksi'      => $no_transaksi2,
                    'tanggal'           => date('Y-m-d'),
                    'keterangan'        => 'Gaji Freelance ' . $items->name,
                    'nominal'           => $gaji,
                    'id_register'       => null,
                    'id_account'        => '17',
                    'DK'                => 'D',
                    'id_temp'           => null,
                    'ekstra'            => ''
                ]);

                Data_transaksi::create([
                    'no_transaksi'      => $no_transaksi2,
                    'tanggal'           => date('Y-m-d'),
                    'keterangan'        => 'Gaji Freelance ' . $items->name,
                    'nominal'           => $gaji,
                    'id_register'       => null,
                    'id_account'        => '2',
                    'DK'                => 'K',
                    'id_temp'           => null,
                    'ekstra'            => ''
                ]);
            }

            //update created_by agar tidak bisa diedit untuk konsistensi data
            $awal   = date('Y-m-26', strtotime('-2 month', strtotime(date('Y-m-01'))));
            $akhir  = date('Y-m-25', strtotime('-1 month', strtotime(date('Y-m-01'))));

            Pekerjaan::where('tgl', '>=' , $awal)->where('tgl', '<=' , $akhir)->update([
                'created_by'    => '0'
            ]);

            DB::commit();


            //add log
            Log::channel('info')->info('Task Scheduler : ', [
                'success'  => 'Import Gaji Freelance ke Laba Rugi'
            ]);

            NotificationDiscord('SUKSES : ', 'Import Gaji Freelance ke Laba Rugi');
        } catch (\Exception $e) {
            DB::rollback();

            //add log
            Log::channel('info')->info('GAGAL : ', [
                'error'  => $e
            ]);

            Log::channel('discord')->info('GAGAL Import Gaji Freelance ke Laba Rugi : ', [
                'error'  => $e
            ]);
        }
    }
}
