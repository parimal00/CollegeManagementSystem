<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $fee_info = DB::table('fee_info')
                ->where('fee_type', 'library_penalty')
                ->join('fees_amount', 'fees_amount.fee_info_id', 'fee_info.id')
                ->orderByDesc('fees_amount.fee_id')
                ->first();


            $penalty_info = DB::table('issue_books')
                ->whereDate('books_issue_date', '<', now()->subMonths(3))
                ->where('books_return_date', null)
                ->where('penalty', 0)
                ->join('student_registration', 'student_registration.roll_no', 'issue_books.student_enrollment')
                ->get();



            DB::table('issue_books')
                ->whereDate('books_issue_date', '<', now()->subMonths(3))
                ->where('books_return_date', null)
                ->update([
                    'penalty' => 1
                ]);

            foreach ($penalty_info as $info) {

                DB::table('student_account')
                    ->insert([
                        'roll_no' => $info->student_enrollment,
                        'fee_id' => $fee_info->fee_id,
                        'fees_type' => 'fees_amount',
                        'semester' => $info->semester,
                        'date' => now()
                    ]);
            }
        })->daily()
            ->onSuccess(function () {
                Log::notice('executed scheduler successfully');
            });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
