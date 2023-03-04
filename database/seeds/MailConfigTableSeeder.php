<?php

use Illuminate\Database\Seeder;

class MailConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'code' => 'forgot_password',
            'title' => 'Your new newcenturylabs.com password',
            'body' => '<p>Dear {{NAME}}</p>

                        <p>If you&#39;ve forgotten your password no worries, simply copy and paste your temporary password to this link below then create your unique password under &quot;My Account.&quot;</p>

                        <p>New password: {{PASSWORD}}</p>

                        <p>For your convenience, you can change your password by visiting the &quot;My Account&quot; section of our website.</p>

                        <p>Please email or call customer service if you have any questions.</p>

                        <p>Regards,</p>

                        <p>New Century Labs</p>

                        <p><strong><u>HIPAA Notice</u></strong></p>

                        <p>The contents of this message, together with any attachments, are intended only for the use of the person(s) to which they are addressed and may contain confidential and/or privileged information. Further, any medical information herein is confidential and protected by law. It is unlawful for unauthorized persons to use, review, copy, disclose, or disseminate confidential medical information. If you are not the intended recipient, immediately advise the sender and delete this message and any attachments. Any distribution, or copying of this message, or any attachment, is prohibited.</p>
                        '
            ],
        ];

        \App\Models\MailConfig::insert($data);
    }
}
