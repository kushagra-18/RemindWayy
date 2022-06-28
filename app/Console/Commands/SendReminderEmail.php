<?php

namespace App\Console\Commands;

use App\Mail\RemindMail;
use App\Reminder;
use Error;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Send:Email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use to send Reminder Email';



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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Cron Job Started');

        // get 5 minutes before the reminder time
        $time = date('H:i', strtotime('+5 minutes'));
        
        $this->info('The time is ' . date('H:i'). ' Reminder Time ' .$time);
        try{

        $reminders = Reminder::join('users', 'users.id', '=', 'reminders.user_id')
            ->select('reminders.*', 'users.email', 'users.name','users.phone')
            ->where('date', '=', date('Y-m-d'))
            ->where('time', '=', $time)
            ->get();

            // count of reminders for the time
            $count = $reminders->count();
            $this->info('Count of reminders for the time: ' . $count);
           

        foreach ($reminders as $reminder) {

            if($reminder->phone){
                error_log('Phone is present');
                $this->sendSMS($reminder);
            }

            Mail::to($reminder['email'])->send(new RemindMail($reminder));
        }
    }
    catch(\Exception $e){
        $this->error("Critical Error: ".$e->getMessage());
    }

        $this->info('End of Reminder Email Cron for this minute');
    }

    public function sendSMS($reminder){

	$apiKey = env('SMS_API_KEY');

	$sender = urlencode('TXTLCL');
	$message = rawurlencode('Hello'. $reminder['name'] . '! This is a reminder for you for ' . $reminder['description']);
 
	$numbers =  $reminder['phone'];
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	echo $response;

    }
}
