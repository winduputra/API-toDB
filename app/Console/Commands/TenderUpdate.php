<?php

namespace App\Console\Commands;

use App\Models\Tender;
use App\Models\TenderParticipant;
use App\Models\TenderSchedule;
use App\Models\Vendor;
use App\Services\TenderParticipantService;
use App\Services\TenderScheduleService;
use App\Services\TenderService;
use Illuminate\Console\Command;

class TenderUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tender:update {--year=} {--filter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update data tender';

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
        $year       = $this->option('year');
        $filter     = $this->option('filter');
        $all        = true;

        if( $filter == "done" ) {
            $all    = false;
        }

        if( $all ) {
            $this->info("Get Done");
            $tenders    = TenderService::getDone($year);
        } else {
            $this->info("Get All");
            $tenders    = TenderService::getAll($year);
        }
       
        $this->info("Update Tender ITEM");
        foreach ($tenders as $item) {
            $payloads   = [
                'kd_tender' => $item->kd_tender,
            ];
            $tender     = Tender::firstOrCreate($payloads);
            $item       = (array) $item;
            $tender->update($item);
        }

        $this->info("Update Tender SCHEDULE");
        foreach ($tenders as $item) {
            $item   = (array) $item;
            $schedules  = TenderScheduleService::getByCode($item['kd_tender']);
            
            foreach ($schedules as $value) {
                $schedule   = TenderSchedule::firstOrCreate([
                    'kd_lelang' => $item['kd_tender'],
                    'kd_tahapan' => $value->kd_tahapan,
                ]);
                $payload    = (array) $value;
                $schedule->update($payload);
            }
            sleep(1);
        }

        $this->info("Update Tender PARTICIPANTS");
        foreach ($tenders as $item) {
            $item   = (array) $item;
            $participants    = TenderParticipantService::getByCode($item['kd_tender']);
            if( $participants AND count($participants) ) {
                foreach ($participants as $value) {
                    $participant    = TenderParticipant::firstOrCreate([
                        'kd_tender' =>  $item['kd_tender'],
                        'kd_peserta' => $value->kd_peserta,
                    ]);
                    $payload    = (array) $value;
                    $participant->update($payload);

                    $payloadVendor  = [
                        'kd_penyedia' => $value->kd_penyedia,
                        'nama_penyedia' => $value->nama_penyedia,
                        'npwp_penyedia' => $value->npwp_penyedia,
                    ];
                    $this->info(json_encode($payloadVendor));

                    $vendor     = Vendor::firstOrCreate($payloadVendor);
                }
            }
            sleep(1);
        }
    }
}
