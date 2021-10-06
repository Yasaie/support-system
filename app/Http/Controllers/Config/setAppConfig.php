<?php
namespace App\Http\Controllers\Config;

use App\Config;
use App\Http\Controllers\Config\getConfig;

class setAppConfig {
	public static function setAll(){
		$settings=[
			'app.name'=>getConfig::site_name(), // application name
			'app.logo.src'=>getConfig::site_logo_src(), // application image logo
			'app.logo.alt'=>getConfig::site_logo_alt(), // application image alt
			'app.url'=>getConfig::site_address(), // application ticket url
			'main.url'=>getConfig::main_address(), // application main url
			'app.description'=>getConfig::site_description(), // application description
			'app.keywords'=>getConfig::site_keywords(), // application keywords
			'app.rules'=>getConfig::site_rules(), // application main rules
			'app.landingPage.status'=>getConfig::site_landing_page_status(), // landing page status that shows it is active or not
			'app.guestTicket.status'=>getConfig::site_guest_ticket_status(), // guest ticket status that shows user's cant send ticket or not?
			'app.registration.status'=>getConfig::site_registration_status(), //registeration status , show that new users can register or not?
			'app.author'=>'backEnd:mahdiKhanzadi & frontEnd:mahyarAnsary', //application authors (programmers name)
			'app.favicon'=>asset('images/favicon.png'), //application shortcut icon (favicon)
			'app.mobile_format' => '(09(?:[0-9]){9})', //application mobile format to verify mobile number

			//SMTP mail configs
			'mail.host'=>getConfig::site_smtp_server(),
			'mail.port'=>getConfig::site_smtp_port(),
			'mail.username'=>getConfig::site_smtp_username(),
			'mail.password'=>getConfig::site_smtp_password(),
			'mail.from.address'=>getConfig::site_main_email(),
			'mail.from.activitiesAddress'=>getConfig::site_activities_email(),
			'mail.from.name'=>getConfig::site_name(),

			//SMS message configs
			'sms.username'=>getConfig::site_sms_username(),
			'sms.password'=>getConfig::site_sms_password(),
			'sms.number'=>getConfig::site_sms_number(),
			'sms.db.log'=>true,

			//ticket configs
			'ticket.remove.status'=>getConfig::ticket_remove_status(),
			'ticket.attachment.status'=>getConfig::ticket_attachment_status(),
			'ticket.attachment.file.formats'=>getConfig::ticket_attachment_file_formats(),
			'ticket.attachment.file.size'=>getConfig::ticket_attachment_file_size(),
			'ticket.attachment.file.count'=>getConfig::ticket_attachment_file_count(),
			'ticket.department.substitution.status'=>getConfig::ticket_department_substitution_status(),
			'ticket.rating.status'=>getConfig::ticket_rating_status(),

			'user.closeTicket.status'=>getConfig::user_close_ticket_status(),
			'staff.closeTicket.status'=>getConfig::staff_close_ticket_status(),
			'user.removeTicket.status'=>getConfig::user_remove_ticket_status(),
			'staff.removeTicket.status'=>getConfig::staff_remove_ticket_status(),

			'email.verification.status'=>getConfig::email_verification_status(),

			'app.core.version'=>getConfig::core_version(),
			'app.core.name'=>'Patronic.ir',
			'app.core.url'=>'https://patronic.ir',//to receive news and updates

			'mobile.verification.status'=>getConfig::mobile_verification_status(),
			'email.notification.status'=>getConfig::email_notification_status(),
			'sms.notification.status'=>getConfig::sms_notification_status(),

			'widget1.title'	 =>getConfig::widget1_title(),
			'widget1.content' =>getConfig::widget1_content(),
			'widget2.title'	 =>getConfig::widget2_title(),
			'widget2.content' =>getConfig::widget2_content(),
			'widget3.title'	 =>getConfig::widget3_title(),
			'widget3.content' =>getConfig::widget3_content(),

		];

		config($settings);
	}
}