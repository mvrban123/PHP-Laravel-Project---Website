<?php 

namespace App\Modules\Helpers;
use DateTime;
use Cron\CronExpression;
use App\Models\AutoPorukaPostavke;
use App\Models\TipOdgode;

class BaseAutoPorukeJobHelper
{   
    private $autoPorukaObj = null;
    private $tipOdgode = null;


    /**
     * Konstruktor klase. Kao parametar prima naziv vrste automatske
     * poruke koja se želi izvršiti. 
     * Vidi u BP: 
     *  tablica: auto_poruke_postavke;
     *  atribut: naziv
     * 
     */
    public function __construct($auto_poruka_naziv)
    {
        $this->autoPorukaObj = $this->getAutoPoruka($auto_poruka_naziv);
        $this->tipOdgode = $this->autoPorukaObj->tipovi_odgode;
    }

    /**
     * Izvršava posao (Job) slanja automatske poruke.
     * Kao parametre prima instancirani objekt posla koji se treba
     * izvršiti i podatke koje posao koristi. 
     */
    public function dispatchJob($jobToDispatch, $jobPayloadData)
    {
        $autoMsgEnabled = $this->autoPorukaObj->omoguceno;
        if($autoMsgEnabled)
        {
            $delayInMinutes = $this->getDelayInMinutes();
    
            if(!$delayInMinutes)
            {
                # izvrsi odmah
                $jobToDispatch->dispatch($jobPayloadData);
            }
    
            else{
                # odgodi izvrsenje
                $jobToDispatch->dispatch($jobPayloadData)->delay(
                    now()->addMinutes($delayInMinutes)
                );
            }
        }

        return $autoMsgEnabled;
    }


    /**
     * Dohvaća podatak o vremenskoj odgodi slanja auto. poruke u minutama.
     */
    public function getDelayInMinutes()
    {
        $delayInMinutes = 0;

        if ($this->tipOdgode->odgodjeno)
        {
            $delayInMinutes = $this->tipOdgode->minute;
        }

        elseif ($this->tipOdgode->fiksni_interval)
        {
            $cronDateTime = $this->getDateTimeFromCronExpression(
                $this->tipOdgode->cron_izraz
            );

            $dateTimeNow = new DateTime();

            $dateTimeDifference = $dateTimeNow->diff($cronDateTime);

            $delayInMinutes = $this->getDateTimeDifferenceInMinutes(
                $dateTimeDifference
            );
        }

        return $delayInMinutes;
    }


    /**
     * Stvara i vraća DateTime objekt iz CRON sintakse zadane u postavkama
     * auto. poruke (ako se poruka šalje na fiskni interval).
     */
    private function getDateTimeFromCronExpression($cronExpression)
    {
        $cronObj = CronExpression::factory($cronExpression);
        $cronObj->isDue();

        # @return \DateTime
        $nextDateToRun = $cronObj->getNextRunDate();

        return $nextDateToRun;
    }

    /**
     * Pomoćna metoda za izračunavanje vremenske razlike iz DateTime::diff
     * objekta u minute.
     */
    private function getDateTimeDifferenceInMinutes($dateTimeDifference)
    {
        $diffInMinutes = $dateTimeDifference->days * 24 * 60;
        $diffInMinutes += $dateTimeDifference->h * 60;
        $diffInMinutes += $dateTimeDifference->i;

        return $diffInMinutes + 1;
    }


    /**
     * Dohvaća i vraća model AutoPorukaPostavke koji sadrži zapis
     * o postavkama auto. poruke iz BP.
     */
    private function getAutoPoruka($auto_poruka_naziv)
    {
        $autoPoruka = AutoPorukaPostavke::where(
            'naziv', $auto_poruka_naziv
        )->first();

        return $autoPoruka;
    }
}