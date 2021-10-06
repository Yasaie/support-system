<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//define config keys:
		DB::table('configs')->insert([
			//site configs
			['name' => 'site_name','value' => 'patronic','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_logo_src','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_logo_alt','value' => 'patronic','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'main_address','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_address','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_description','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_keywords','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_rules','value' => 'ثبت نام شما صرفا جهت استفاده از سیستم تیکت (پشتیبانی) میباشد و تمامی فعالیت های شما ثبت و ضبط خواهد شد , در صورت سوء استفاده از سیستم و بی احترامی به افراد, این اطلاعات جهت پیگیری به سازمان دارای صلاحیت ارجاع داده خواهد شد.','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_landing_page_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_guest_ticket_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_registration_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_main_email','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_activities_email','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_smtp_server','value' => 'localhost','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_smtp_port','value' => '487','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_smtp_username','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_smtp_password','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//sms configs
			['name' => 'site_sms_username','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_sms_password','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'site_sms_number','value' => null,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//ticket configs
			['name' => 'ticket_remove_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'ticket_attachment_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'ticket_attachment_file_formats','value' => 'jpg|jpeg|png|txt|pdf|doc|gif|tif|webp','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'ticket_attachment_file_size','value' => '5','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'ticket_attachment_file_count','value' => '2','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'ticket_department_substitution_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'ticket_rating_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//user configs
			['name' => 'user_close_ticket_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'user_remove_ticket_status','value' => false,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//staff configs
			['name' => 'staff_close_ticket_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'staff_remove_ticket_status','value' => true,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//core configs
			['name' => 'core_version','value' => '1.0 alpha','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//verifications
			['name' => 'email_verification_status','value' => false,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'mobile_verification_status','value' => false,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			//notification
			['name' => 'email_notification_status','value' => false,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'sms_notification_status','value' => false,'created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],

			['name' => 'widget1_title','value' => 'پشتیبانی چه روزهایی انجام میشود','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'widget1_content','value' => 'شنبه تا چهارشنبه','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'widget2_title','value' => 'در چه ساعاتی پشتیبانی ارائه میشود','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'widget2_content','value' => '8 تا 18','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'widget3_title','value' => 'شماره های تماس واحد پشتیبانی','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
			['name' => 'widget3_content','value' => '021-23549863','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
		]);
    }
}
