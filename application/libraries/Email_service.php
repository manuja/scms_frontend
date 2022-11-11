<?php

// defined('BASEPATH') OR exit('No direct script access allowed');


class Email_service {

    private $transport;
    private $mailer;
    private $email_master_switch;
    private $user_id;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->helper('master_tables');
        $this->CI->load->library('session');
        $this->transport = (new Swift_SmtpTransport('mail.test.lk', 587, 'tls'))
                ->setUsername('dev@test.lk')
                ->setPassword('~J-jztux@,Bm');

        $this->mailer = new Swift_Mailer($this->transport);

        $email_master_switch_res = getSystemVariable('email_master_switch');

        $this->email_master_switch = (int) $email_master_switch_res[0]->system_variable_value;

        if ($this->CI->session->userdata('user_id') != null) {
            $this->user_id = $this->CI->session->userdata('user_id');
        } else { // public users
            $this->user_id = 0;
        }
    }

    public function reSendEmail($recipients, $subject, $body, $attachments, $pre_email_id, $email_type = null) {
        if ($this->email_master_switch) {

            if (!$this->user_id) {
                $this->user_id = 0;
            }
            $data = array(
                'subject' => $subject,
                'body' => $body,
                'sender' => '',
                'sent_date' => date('Y-m-d'),
                'total_recipients' => sizeof($recipients),
                'updated_by' => $this->user_id,
                'parent_email_id' => $pre_email_id,
                'email_type_id' => $email_type
            );
            $this->CI->db->insert('emails_tbl', $data);
            $email_insert_id = $this->CI->db->insert_id();
            if ($attachments != null) {
                foreach ($attachments as $attachment) {
                    $data2 = array(
                        'email_id' => $email_insert_id,
                        'attachment' => $attachment,
                    );
                    $this->CI->db->insert('email_attachments', $data2);
                }
            }
            foreach ($recipients as $recipient) {
                $data3 = array(
                    'email_id' => $email_insert_id,
                    'recipient_user_id' => $recipient['recipient_user_id'],
                    'recipient_email_address' => $recipient['recipient_email_address'],
                );
                $this->CI->db->insert('email_schedule', $data3);
            }
        }

        $res = array('STATUS' => 1, 'MESSAGE' => 'Email was sent successfully!');

        return json_encode($res);
    }

    public function sendEmail($recipients, $subject, $body, $email_type = null,$header = 1) {
        if ($this->email_master_switch) {
            $body .= '';
            if($header == 1){
                $header = '';
            }else{
                $header = '';
            }
            $footer = '<hr><ul></ul>';
            $footer .= '<p style="text-align: right;">Powered by <a href="www.testinfotech.com">www.testinfotech.com</a></p>';

            $new_body = $header . $body . $footer;

            if (!$this->user_id) {
                $this->user_id = 0;
            }
            $data = array(
                'subject' => $subject,
                'body' => $new_body,
                'sender' => '',
                'sent_date' => date('Y-m-d'),
                'total_recipients' => sizeof($recipients),
                'updated_by' => $this->user_id,
                'email_type_id' => $email_type
            );
            $this->CI->db->insert('emails_tbl', $data);
            $email_insert_id = $this->CI->db->insert_id();

            foreach ($recipients as $recipient) {
                if ($recipient != '') {
                    $this->CI->db->select('id');
                    $this->CI->db->from('users');
                    $this->CI->db->where('email', $recipient);
                    $user_id_row = $this->CI->db->get();
                    $user_id = 0;
                    if ($user_id_row->num_rows() > 0) {
                        $user_id = $user_id_row->row()->id;
                    }
                    $data2 = array(
                        'email_id' => $email_insert_id,
                        'recipient_user_id' => $user_id,
                        'recipient_email_address' => $recipient,
                    );
                    $this->CI->db->insert('email_schedule', $data2);
                }
            }
        }

        $res = array('STATUS' => 1, 'MESSAGE' => 'Email was sent successfully!');

        return json_encode($res);
    }

    public function sendEmailWithAttachments($recipients, $subject, $body, $attachments, $email_type = null,$header=1) {
        if ($this->email_master_switch) {
            
            $body .= '';
            if($header == 1){
                $header = '';
            }else{
                $header = '';
            }
            $footer = '<hr><ul></ul>';
            $footer .= '<p style="text-align: right;">Powered by <a href="www.testinfotech.com">www.testinfotech.com</a></p>';

            $new_body = $header . $body . $footer;
            
            if (!$this->user_id) {
                $this->user_id = 0;
            }
            $data = array(
                'subject' => $subject,
                'body' => $new_body,
                'sender' => '',
                'sent_date' => date('Y-m-d'),
                'total_recipients' => sizeof($recipients),
                'has_attachment' => 1,
                'updated_by' => $this->user_id,
                'email_type_id' => $email_type
            );
            $this->CI->db->insert('emails_tbl', $data);
            $email_insert_id = $this->CI->db->insert_id();

            foreach ($attachments as $attachment) {
                $data2 = array(
                    'email_id' => $email_insert_id,
                    'attachment' => $attachment,
                );
                $this->CI->db->insert('email_attachments', $data2);
            }

            foreach ($recipients as $recipient) {
                if ($recipient != '') {
                    $this->CI->db->select('id');
                    $this->CI->db->from('users');
                    $this->CI->db->where('email', $recipient);
                    $user_id_row = $this->CI->db->get();
                    $user_id = 0;
                    if ($user_id_row->num_rows() > 0) {
                        $user_id = $user_id_row->row()->id;
                    }
                    $data3 = array(
                        'email_id' => $email_insert_id,
                        'recipient_user_id' => $user_id,
                        'recipient_email_address' => $recipient,
                    );
                    $this->CI->db->insert('email_schedule', $data3);
                }
            }
        }

        $res = array('STATUS' => 1, 'MESSAGE' => 'Email was sent successfully!');

        return json_encode($res);
    }

    public function createEmailTemplate($template_name, $subject, $body) {
        $data = array(
            'name' => $template_name,
            'subject' => $subject,
            'body' => $body
        );

        $this->CI->db->insert('email_templates', $data);

        $res = array('STATUS' => 1, 'MESSAGE' => 'Email template was created successfully!');

        return json_encode($res);
    }

    public function updateEmailTemplate($email_template_id, $template_name, $subject, $body) {
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

    public function getEmailTemplateById($template_id) {
        $this->CI->db->where('email_templates', $template_id);
        $data = $this->CI->db->get('email_templates');

        return json_encode($data->result());
    }

    public function getEmailTemplateByName($template_name) {
        $this->CI->db->like('name', $template_name, 'both');
        $data = $this->CI->db->get('email_templates');

        return json_encode($data->result());
    }

    public function sendEmailTemplate($template_name, $recipients, $email_type = null) {
        $template = json_decode($this->getEmailTemplateByName($template_name));

        $data = array(
            'subject' => $template[0]->subject,
            'body' => $template[0]->body,
            'sender' => '',
            'sent_date' => date('Y-m-d'),
            'total_recipients' => sizeof($recipients),
            'email_type_id' => $email_type
        );
        $this->CI->db->insert('emails_tbl', $data);
        $email_insert_id = $this->CI->db->insert_id();

        $result_arr = array();

        $recipient_chunks = array_chunk($recipients, 500);

        $subject = $template[0]->subject;

        $body = $template[0]->body;

        foreach ($recipient_chunks as $recipient_chunk) {
            foreach ($recipient_chunk as $recipient) {
                $this->CI->db->select('id');
                $this->CI->db->from('users');
                $this->CI->db->where('email', $recipient['email']);
                $user_id_row = $this->CI->db->get();
                $user_id = 0;
                if ($user_id_row->num_rows() > 0) {
                    $user_id = $user_id_row->row()->id;
                }
                $generated_no = (int) date('YmdHs') . rand(10000000, 99999999);
                $data2 = array(
                    'email_id' => $email_insert_id,
                    'recipient_user_id' => $user_id,
                    'recipient_email_address' => $recipient['email'],
                    'generate_no'=>$generated_no,
                );
                $this->CI->db->insert('email_recipients', $data2);

                $new_body = str_replace('%name%', $recipient['name'], $body);

                $new_body2 = str_replace('%user_id%', $generated_no, $new_body);

                $message = (new Swift_Message($subject))
                        ->setFrom(['test.lk' => ''])
                        ->setReplyTo(['test.lk' => 'test'])
                        ->setTo([$recipient['email']])
                        ->setBody($new_body2, 'text/html')
                ;

                $result = $this->mailer->send($message);

                array_push($result_arr, $result);
            }
        }

        $email_send_statuses = array_count_values($result_arr);

        $res = '';

        if ($email_send_statuses['1'] == sizeof($recipients)) {
            foreach ($recipients as $recipient) {
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

    public function sendSingleEmail($recipient, $subject, $body) {
        //        echo $recipient;
        //        echo $subject;
        //        echo $body;
        //        exit;
        //        if ($this->email_master_switch) {
        if (!$this->user_id) {
            $this->user_id = 0;
        }

        $message = (new Swift_Message($subject))
                ->setFrom(['dev@test.lk' => 'test infotech (pvt) ltd'])
                ->setReplyTo(['dev@test.lk' => 'test infotech (pvt) ltd'])
                ->setTo([$recipient])
                ->setBody($body, 'text/html');

        if (!$this->mailer->send($message, $failures)) {

            return false;
        } else {

            return true;
        }
        //        }
    }

    public function sendSingleEmail_with_attachment($recipient, $subject, $body,$attachment,$file_name) {
    
        if (!$this->user_id) {
            $this->user_id = 0;
        }

        

        $message = (new Swift_Message($subject))
                ->setFrom(['dev@test.lk' => 'test infotech (pvt) ltd'])
                ->setReplyTo(['dev@test.lk' => 'test infotech (pvt) ltd'])
                ->setTo([$recipient])
                ->setBody($body, 'text/html')
                ->attach(
                    Swift_Attachment::fromPath($attachment)->setFilename($file_name)
                    );

        if (!$this->mailer->send($message, $failures)) {

            return false;
        } else {

            return true;
        }
        //        }
    }
/*
 * created by test
 * Date : 2019/07/29
 * check member subscribe or not the email type of email.
 * if member unsubscribe the email type,that will not send,otherwise email send.
 */
    public function checkEmailCategoryForMember($user_id, $email_id) {
        //get email type set for email.
        $this->CI->db->select('master_email_types.email_type');
        $this->CI->db->from('emails_tbl');
        $this->CI->db->join('master_email_types', 'master_email_types.email_type_id = emails_tbl.email_type_id', 'left');
        $this->CI->db->where('emails_tbl.email_id', $email_id);
        $type = $this->CI->db->get()->result();

        if ($type[0]->email_type != NULL) {
            $email_type = $type[0]->email_type;

            $this->CI->db->select('*');
            $this->CI->db->from('member_email_types');
            $this->CI->db->where('user_id', $user_id);
            $row = $this->CI->db->get()->result();

            if ($row) {
                if ($row[0]->$email_type == '1') {
                    return true;
                } else {
                    return FALSE;
                }
            } else {
                //not set allowed email types for member.           
                return true;
            }
        } else {
            return true;
        }
    }

}
