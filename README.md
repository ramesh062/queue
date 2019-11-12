## Laravel queue

(1) first configure queue type : redis,database,sync,beanstalkd,sqs
	default sync type is set in .env file

(2) if you use database queue type so you can run below command
		
	change of queue type in .env file sync to database

	**php artisan queue:table** for store job record
	**php artisan queue:failed-table** for store failed job record
	**php artisan migrate**


(3) if you use redis queue type so you need to install redis server in your 	laravel by using below command 
	
	change of queue type in .env file sync to redis
	
	**composer require predis/predis**

	-install redis in your system

	- for start redis server
		/etc/init.d/redis-server start
	- for stop redis server
		/etc/init.d/redis-server stop
	- check redis server start or not in your system
		redis-cli ping
		 Output: PONG

(4) create mail
	
	-for create new file in your app\Mail\SendEmail.php
	**php artisan make:mail SendEmail**

	- create email template in your resources/email/email.blade.php file

(6)  create job
	
	-for create new file in your app\Jobs\EmailJob.php
	**php artisan make:job EmailJob**

(7) In app\Http\Controllers\HomeController.php for Dispatch job
	
	**EmailJob::dispatch($data);**

	public function sendEmail(Request $request)
    {
        $data=[
            'subject'=>'demo for send email by job',
            'message'=>'queue and job demo for send email.'
        ];

        EmailJob::dispatch($data);
        return redirect('home');
    }
(8) In app\Jobs\EmailJob.php

	- we can send email by handle method in EmailJob

		public function handle()
    	{
        	Log::info("send email");
        	Mail::to(env('EMAIL'), env('NAME'))->send(new SendEmail($this->data));
    	}

(9) In app\Mail\SendEmail.php
	
	we set email template with require data

	public function build()
    {
        return $this->view('emails.email',['data'=>$this->data]);
    }


 (10) we need to run job by cron job
 	
 	-for specific queue
 	
 	 $schedule->job(new EmailJob)->everyFiveMinutes();

    - for all queue
    
    	$schedule->command('queue:work')->everyMinute();

  (11) you must set cron job in your server
  	
  	In your terminal run below command 
  	
  	-crontab -l for list of cron job

  	-cronjob -e for add or edit new cron job

  	-your laravel project path (queue is my laravel folder name)

  	* * * * * php /var/www/html/queue/artisan schedule:run >> /dev/null 2>&1




