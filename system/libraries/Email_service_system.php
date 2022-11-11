<?php // defined('BASEPATH') OR exit('No direct script access allowed');

class CI_email_service_system
{
	private $transport;

	private $mailer;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->transport = (new Swift_SmtpTransport('email-smtp.us-east-1.amazonaws.com', 25, 'tls'))
		->setUsername('AKIAIADMIAMPGZPRQ4VQ')
		->setPassword('BMvGwd1vDq1COvMyRdApoQelI+NAJJXQZ2th10qTMLNb')
		;

		$this->mailer = new Swift_Mailer($this->transport);
	}

	public function sendEmail($recipients, $subject, $body)
	{
		$body .= '<object data="https://i.stack.imgur.com/HOwkY.png" type="image/png"><img src="'.site_url('Emails/handleOpen/%user_id%').'"></object>';

		$data = array(
			'subject' => $subject,
			'body' => $body,
			'sender' => 'testweb@test.lk',
			'sent_date' => date('Y-m-d'),
			'total_recipients' => sizeof($recipients)
		);
		$this->CI->db->insert('emails_tbl', $data);
		$email_insert_id = $this->CI->db->insert_id();

		foreach($recipients as $recipient) {
			$this->CI->db->select('id');
			$this->CI->db->from('users');
			$this->CI->db->where('email', $recipient);
			$user_id_row = $this->CI->db->get();
			$user_id = 0;
			if($user_id_row->num_rows() > 0) {
				$user_id = $user_id_row->row()->id;
			}
			$data2 = array(
				'email_id' => $email_insert_id,
				'recipient_user_id' => $user_id,
				'recipient_email_address' => $recipient,
			);
			$this->CI->db->insert('email_schedule', $data2);
		}

		$res = array('STATUS' => 1, 'MESSAGE' => 'Email was sent successfully!');
		
		return json_encode($res);
	}

	public function sendEmailWithAttachments($recipients, $subject, $body, $attachments)
	{
		$body .= '<object data="https://i.stack.imgur.com/HOwkY.png" type="image/png"><img src="'.site_url('Emails/handleOpen/%user_id%').'"></object>';

		$data = array(
			'subject' => $subject,
			'body' => $body,
			'sender' => 'testweb@test.lk',
			'sent_date' => date('Y-m-d'),
			'total_recipients' => sizeof($recipients),
			'has_attachment' => 1
		);
		$this->CI->db->insert('emails_tbl', $data);
		$email_insert_id = $this->CI->db->insert_id();

		foreach($attachments as $attachment) {
			$data2 = array(
				'email_id' => $email_insert_id,
				'attachment' => $attachment,
			);
			$this->CI->db->insert('email_attachments', $data2);
		}

		foreach($recipients as $recipient) {
			$this->CI->db->select('id');
			$this->CI->db->from('users');
			$this->CI->db->where('email', $recipient);
			$user_id_row = $this->CI->db->get();
			$user_id = 0;
			if($user_id_row->num_rows() > 0) {
				$user_id = $user_id_row->row()->id;
			}
			$data3 = array(
				'email_id' => $email_insert_id,
				'recipient_user_id' => $user_id,
				'recipient_email_address' => $recipient,
			);
			$this->CI->db->insert('email_schedule', $data3);
		}

		$res = array('STATUS' => 1, 'MESSAGE' => 'Email was sent successfully!');
		
		return json_encode($res);
	}

	public function createEmailTemplate($template_name, $subject, $body)
	{
		$data = array(
			'name' => $template_name,
			'subject' => $subject,
			'body' => $body
		);

		$this->CI->db->insert('email_templates', $data);

		$res = array('STATUS' => 1, 'MESSAGE' => 'Email template was created successfully!');

		return json_encode($res);
	}

	public function updateEmailTemplate($email_template_id, $template_name, $subject, $body)
	{
		$data = array(
			'name' => $template_name,
			'subject' => $subject,
			'body' => $body
		);

		$this->CI->db->where('email_template_id', $email_template_id);
		$this->CI->db->update('email_templates', $data);

		$res = array('STATUS' => 1, 'MESSAGE' => 'Email template was updated successfully!');

		return json_encode($res);
	}

	public function getEmailTemplateById($template_id)
	{
		$this->CI->db->where('email_templates', $template_id);
		$data = $this->CI->db->get('email_templates');

		return json_encode($data->result());
	}

	public function getEmailTemplateByName($template_name)
	{
		$this->CI->db->like('name', $template_name, 'both');
		$data = $this->CI->db->get('email_templates');

		return json_encode($data->result());
	}

	public function sendEmailTemplate($template_name, $recipients)
	{
		$template = json_decode($this->getEmailTemplateByName($template_name));

		$data = array(
			'subject' => $template[0]->subject,
			'body' => $template[0]->body,
			'sender' => 'testweb@test.lk',
			'sent_date' => date('Y-m-d'),
			'total_recipients' => sizeof($recipients)
		);
		$this->CI->db->insert('emails_tbl', $data);
		$email_insert_id = $this->CI->db->insert_id();

		$result_arr = array();

		$recipient_chunks = array_chunk($recipients, 500);

		$subject = $template[0]->subject;

		$body = $template[0]->body.'<object data="https://i.stack.imgur.com/HOwkY.png" type="image/png"><img src="'.site_url('Emails/handleOpen/%user_id%').'"></object>';

		foreach($recipient_chunks as $recipient_chunk) {
			foreach($recipient_chunk as $recipient) {
				$this->CI->db->select('id');
				$this->CI->db->from('users');
				$this->CI->db->where('email', $recipient['email']);
				$user_id_row = $this->CI->db->get();
				$user_id = 0;
				if($user_id_row->num_rows() > 0) {
					$user_id = $user_id_row->row()->id;
				}
				$data2 = array(
					'email_id' => $email_insert_id,
					'recipient_user_id' => $user_id,
					'recipient_email_address' => $recipient['email'],
				);
				$this->CI->db->insert('email_recipients', $data2);

				$new_body = str_replace('%name%', $recipient['name'], $body);

				$new_body2 = str_replace('%user_id%', $user_id, $new_body);

				$message = (new Swift_Message($subject))
				->setFrom(['testweb@test.lk'])
				->setTo([$recipient['email']])
				->setBody($new_body2, 'text/html')
				;

				$result = $this->mailer->send($message);

				array_push($result_arr, $result);
			}
		}

		$email_send_statuses = array_count_values($result_arr);

		$res = '';

		if($email_send_statuses['1'] == sizeof($recipients)) {
			foreach($recipients as $recipient) {
				$this->CI->db->where('recipient_email_address', $recipient['email']);
				$this->CI->db->where('email_id', $email_insert_id);
				$this->CI->db->update('email_recipients', array('delivered' => 1));
			}
			
			$res = array('STATUS' => 1, 'MESSAGE' => 'Email was sent successfully!');
		} else {
			$res = array('STATUS' => 2, 'MESSAGE' => 'Email was not sent successfully!');
		}

		return json_encode($res);
	}
}