<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([
        	//iran (IR) provinces
 			['id' => '1','name' => 'آذربایجان شرقی','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '2','name' => 'آذربایجان غربی','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '3','name' => 'اردبیل','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '4','name' => 'اصفهان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '5','name' => 'البرز','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '6','name' => 'ایلام','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '7','name' => 'بوشهر','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '8','name' => 'تهران','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '9','name' => 'چهارمحال و بختیاری','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '10','name' => 'خراسان جنوبی','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '11','name' => 'خراسان رضوی','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '12','name' => 'خراسان شمالی','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '13','name' => 'خوزستان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '14','name' => 'زنجان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '15','name' => 'سمنان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '16','name' => 'سیستان و بلوچستان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '17','name' => 'فارس','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '18','name' => 'قزوین','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '19','name' => 'قم','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '20','name' => 'كردستان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '21','name' => 'كرمان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '22','name' => 'كرمانشاه','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '23','name' => 'کهگیلویه و بویراحمد','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '24','name' => 'گلستان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '25','name' => 'گیلان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '26','name' => 'لرستان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '27','name' => 'مازندران','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '28','name' => 'مركزی','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '29','name' => 'هرمزگان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '30','name' => 'همدان','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
 			['id' => '31','name' => 'یزد','country_id'=>'102','created_at' => Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]

		]);
    }
}
