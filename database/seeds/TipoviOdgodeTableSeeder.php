<?php

use Illuminate\Database\Seeder;
use App\Models\TipOdgode;
class TipoviOdgodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipovi_odgode_data_array = $this->createData();

        foreach($tipovi_odgode_data_array as $tip_odgode)
        {
            $tip_odgode->save();
        }
    }

    private function createData() 
    {
        $t0 = new TipOdgode(); // NEMA ODGODE

        # odgoda u minutama
        $t1 = new TipOdgode(); // 5min
        $t2 = new TipOdgode(); // 30 min
        $t3 = new TipOdgode(); // 60 min / 1 h
        $t4 = new TipOdgode(); // 120 min / 2 h
        $t5 = new TipOdgode(); // 300 min / 5h
        $t6 = new TipOdgode(); // 1440 min / 24h

        # fiksni intervali
        # https://crontab.guru/
        $t7 = new TipOdgode();  // PON U 0800
        $t8 = new TipOdgode();  // PON U 1600
        $t9 = new TipOdgode();
        $t10 = new TipOdgode();
        $t11 = new TipOdgode();
        $t12 = new TipOdgode();
        $t13 = new TipOdgode();
        $t14 = new TipOdgode();
        $t15 = new TipOdgode();
        $t16 = new TipOdgode();
        $t17 = new TipOdgode();
        $t18 = new TipOdgode();
        $t19 = new TipOdgode(); // NED u 0800
        $t20 = new TipOdgode(); // NED u 1600

        # nema odgode
        $t0->id = 1;
        $t0->txt_id = 'bez_odgode';
        $t0->naziv = 'Bez odgode';
        $t0->odgodjeno = 0;
        $t0->fiksni_interval = 0;


        # odgode u minutama
        $t1->id = 2;
        $t1->txt_id = 'odg_5min';
        $t1->naziv = 'Odgoda - 5 minuta';
        $t1->odgodjeno = 1;
        $t1->minute = 5;
        $t1->fiksni_interval = 0;

        $t2->id = 3;
        $t2->txt_id = 'odg_30min';
        $t2->naziv = 'Odgoda - 30 minuta';
        $t2->odgodjeno = 1;
        $t2->minute = 30;
        $t2->fiksni_interval = 0;

        $t3->id = 4;
        $t3->txt_id = 'odg_1h';
        $t3->naziv = 'Odgoda - 1 sat';
        $t3->odgodjeno = 1;
        $t3->minute = 60;
        $t3->fiksni_interval = 0;

        $t4->id = 5;
        $t4->txt_id = 'odg_2h';
        $t4->naziv = 'Odgoda - 2 sata';
        $t4->odgodjeno = 1;
        $t4->minute = 120;
        $t4->fiksni_interval = 0;

        $t5->id = 6;
        $t5->txt_id = 'odg_5h';
        $t5->naziv = 'Odgoda - 5 sati';
        $t5->odgodjeno = 1;
        $t5->minute = 300;
        $t5->fiksni_interval = 0;

        $t6->id = 7;
        $t6->txt_id = 'odg_1d';
        $t6->naziv = 'Odgoda - 1 dan';
        $t6->odgodjeno = 1;
        $t6->minute = 1440;
        $t6->fiksni_interval = 0;


        # fiksni intervali
        $t7->id = 8;
        $t7->txt_id = 'odg_pon_j';
        $t7->naziv = 'Ponedjeljkom u 8:00';
        $t7->odgodjeno = 0;
        $t7->fiksni_interval = 1;
        $t7->cron_izraz = '0 8 * * MON';

        $t8->id = 9;
        $t8->txt_id = 'odg_pon_p';
        $t8->naziv = 'Ponedjeljkom u 16:00';
        $t8->odgodjeno = 0;
        $t8->fiksni_interval = 1;
        $t8->cron_izraz = '0 16 * * MON';

        $t9->id = 10;
        $t9->txt_id = 'odg_uto_j';
        $t9->naziv = 'Utorkom u 08:00';
        $t9->odgodjeno = 0;
        $t9->fiksni_interval = 1;
        $t9->cron_izraz = '0 8 * * TUE';

        $t10->id = 11;
        $t10->txt_id = 'odg_uto_p';
        $t10->naziv = 'Utorkom u 16:00';
        $t10->odgodjeno = 0;
        $t10->fiksni_interval = 1;
        $t10->cron_izraz = '0 16 * * TUE';

        $t11->id = 12;
        $t11->txt_id = 'odg_sri_j';
        $t11->naziv = 'Srijedom u 08:00';
        $t11->odgodjeno = 0;
        $t11->fiksni_interval = 1;
        $t11->cron_izraz = '0 8 * * WED';

        $t12->id = 13;
        $t12->txt_id = 'odg_sri_p';
        $t12->naziv = 'Srijedom u 16:00';
        $t12->odgodjeno = 0;
        $t12->fiksni_interval = 1;
        $t12->cron_izraz = '0 16 * * WED';

        $t13->id = 14;
        $t13->txt_id = 'odg_cet_j';
        $t13->naziv = 'Četvrtkom u 08:00';
        $t13->odgodjeno = 0;
        $t13->fiksni_interval = 1;
        $t13->cron_izraz = '0 8 * * THU';

        $t14->id = 15;
        $t14->txt_id = 'odg_cet_p';
        $t14->naziv = 'Četvrtkom u 16:00';
        $t14->odgodjeno = 0;
        $t14->fiksni_interval = 1;
        $t14->cron_izraz = '0 16 * * THU';

        $t15->id = 16;
        $t15->txt_id = 'odg_pet_j';
        $t15->naziv = 'Petkom u 08:00';
        $t15->odgodjeno = 0;
        $t15->fiksni_interval = 1;
        $t15->cron_izraz = '0 8 * * FRI';

        $t16->id = 17;
        $t16->txt_id = 'odg_pet_p';
        $t16->naziv = 'Petkom u 16:00';
        $t16->odgodjeno = 0;
        $t16->fiksni_interval = 1;
        $t16->cron_izraz = '0 16 * * FRI';

        $t17->id = 18;
        $t17->txt_id = 'odg_sub_j';
        $t17->naziv = 'Subotom u 08:00';
        $t17->odgodjeno = 0;
        $t17->fiksni_interval = 1;
        $t17->cron_izraz = '0 8 * * SAT';

        $t18->id = 19;
        $t18->txt_id = 'odg_sub_p';
        $t18->naziv = 'Subotom u 16:00';
        $t18->odgodjeno = 0;
        $t18->fiksni_interval = 1;
        $t18->cron_izraz = '0 16 * * SAT';

        $t19->id = 20;
        $t19->txt_id = 'odg_ned_j';
        $t19->naziv = 'Nedjeljom u 08:00';
        $t19->odgodjeno = 0;
        $t19->fiksni_interval = 1;
        $t19->cron_izraz = '0 8 * * SUN';

        $t20->id = 21;
        $t20->txt_id = 'odg_ned_p';
        $t20->naziv = 'Nedjeljom u 16:00';
        $t20->odgodjeno = 0;
        $t20->fiksni_interval = 1;
        $t20->cron_izraz = '0 16 * * SUN';

        $tipovi_odgode_data_array = array(
            $t0,
            $t1,
            $t2,
            $t3,
            $t4,
            $t5,
            $t6,
            $t7,
            $t8,
            $t9,
            $t10,
            $t11,
            $t12,
            $t13,
            $t14,
            $t15,
            $t16,
            $t17,
            $t18,
            $t19,
            $t20
        );

        return $tipovi_odgode_data_array;
    }
}