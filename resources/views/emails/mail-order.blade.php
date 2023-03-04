<?php
$currency = setting('site.currency');
$orderPrefix = null;
?>
<table style="width:100.0%" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td style="padding:0in 0in 0in 0in" valign="top">
            <p style="margin-top:0in;text-align:center" align="center">
                <img src="{{asset('front/images/email_logo.png')}}" alt="{{ setting('site.title') }}" border="0" ><u></u><u></u>
            </p>
            <div align="center">
                <table style="width:6.25in;background:#fdfdfd;border:solid gainsboro 1.0pt;border-radius:6px!important" border="1" cellpadding="0" cellspacing="0" width="600">
                    <tbody>
                    <tr>
                        <td style="border:none;padding:0in 0in 0in 0in" valign="top">
                            <div align="center">
                                <table style="width:6.25in;background:#557da1;border-top-left-radius:6px!important;border-top-right-radius:6px!important;border-radius:3px 3px 0 0!important" border="0" cellpadding="0" cellspacing="0" width="600">
                                    <tbody>
                                    <tr>
                                        <td style="padding:0in 0in 0in 0in">
                                            <h1 style="margin:0;margin-bottom:.0001pt;line-height:150%; padding-left: 10px"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Arial&quot;,sans-serif;color:white">  New customer order<u></u><u></u></span></h1>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:0in 0in 0in 0in;border-radius:6px!important" valign="top">
                            <div align="center">
                                @include('emails.element.order-info')
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:0in 0in 0in 0in" valign="top">
                            <div align="center">
                                {{setting('site.title')}}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<div class="yj6qo"><strong>HIPAA Notice</strong>
    <p>The contents of this message, together with any attachments, are intended only for the use of the person(s) to
        which they are addressed and may contain confidential and/or privileged information. Further, any medical information
        herein is confidential and protected by law. It is unlawful for unauthorized persons to use, review, copy, disclose,
        or disseminate confidential medical information. If you are not the intended recipient, immediately advise the sender
        and delete this message and any attachments. Any distribution, or copying of this message, or any attachment, is prohibited.
    </p>
</div>
