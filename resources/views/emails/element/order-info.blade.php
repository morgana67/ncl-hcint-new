<table border="0" cellpadding="0" cellspacing="0" width="600">
    <tbody>
    <tr>
        <td style="background:#fdfdfd;padding:0in 0in 0in 0in" valign="top">
            <table style="width:100.0%;border-radius:6px!important" border="0" cellpadding="0" cellspacing="0"
                   width="100%">
                <tbody>
                <tr>
                    <td style="padding:15.0pt 15.0pt 15.0pt 15.0pt" valign="top">
                        @if($message!="")
                            <p style="line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Arial&quot;,sans-serif;color:#737373"> {{ $message }} </span></p>
                        @else
                            <p>Your lab req has been added to our queue, please standby for us to review and approve your order.</p>
                            <p>Your lab req will be available between 30 minutes to 1 hour.</p>
                            <hr>
                            <p><strong>What's next?</strong></p>
                            <p style="margin-bottom: 5px">You will be notified via email in just a few short moments that your lab order is ready with a secure link. </p>
                            <p style="margin-bottom: 5px">You can access your lab order directly from your email, and your account  portal by going to “My Account” then “My Order Detail” to download your lab req after you’ve been notified via email
                            </p>
                            <br>
                            <p><strong>Specimen Collection:</strong></p>
                            <p style="margin-bottom: 5px">Once you have downloaded your req, take it with you to your local Quest PSC, make sure you present  Identification such as a drivers licenses and your lab req. Appointments are not needed, and walk-ins are always welcome. </p>
                            <p>Find a Quest location nearest you:</p>
                            <p><a href="https://appointment.questdiagnostics.com/patient/confirmation" style="font-weight: bold">MyQuest (questdiagnostics.com)</a></p>
                            <br>
                            <p><strong>Accessing Your Results:</strong></p>
                            <p>Normally test results are available 72 hours from the time of your draw. Depending on some tests, results can take slightly longer. Your results will be located under your “My Account” My Orders tab in your portal. </p>
                            <br>
                            <p href="tel:{{ str_replace('-','',setting('site.hotline'))}}" value="{{ setting('site.hotline')}}" target="_blank">Tel: {{ setting('site.hotline')}}</p>
                            <p href="mailto:{{ setting('site.email_receive_notification') }}" target="_blank">Email: {{ setting('site.email_receive_notification') }}</p>
                        @endif
                        <h2 style="margin-right:0in;margin-bottom:6.0pt;margin-left:0in;line-height:130%"><span
                                style="font-size:13.5pt;line-height:130%;font-family:&quot;Helvetica&quot;,sans-serif;color:#557da1"><a
                                    href="{{$link ?? null}}" target="_blank"><span
                                        style="color:#557da1;font-weight:normal">Order: {{$order->id}}</span></a>
                                                                                ({{date('F d,Y',strtotime($order->created_at))}})</span>
                        </h2>
                        <table style="width:100.0%;border:solid #eeeeee 1.0pt" border="1" cellpadding="0"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                    <p class="MsoNormal"><b>Product</b></p>
                                </td>
                                <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                    <p class="MsoNormal"><b>Quantity</b></p>
                                </td>
                                <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                    <p class="MsoNormal"><b>Price</b></p>
                                </td>
                                <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                    <p class="MsoNormal"><b>Total</b></p>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sum = 0;
                            $i = 0;
                            ?>
                            @foreach ($order->details as $product)
                                <?php
                                $rowTotal = $product->price * $product->quantity;
                                $sum += $rowTotal;
                                ?>
                                <tr>
                                    <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt;word-wrap:break-word">
                                        <p><?php echo $product->product->name; ?></p>
                                    </td>
                                    <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal">{{ $product->quantity }}</p>
                                    </td>
                                    <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p><span>{{ $currency }}</span><span>{{ format_price($product->price) }}</span></p>
                                    </td>
                                    <td style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p><span>{{ $currency }}</span><span>{{ format_price($product->price * $product->quantity )  }}</span></p>
                                    </td>
                                </tr>
                            @endforeach

                                <tr>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal"><b>Gender:</b></p>
                                    </td>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal"><span></span><span>@if(user()->gender =='f') Female @else Male @endif

                                                                                                </span><u></u><u></u></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal"><b>D.O.B.<u></u><u></u></b></p>
                                    </td>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal"><span>{{date('M. jS, Y',strtotime($order->dob))}}</span><u></u><u></u></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal"><b>Payment
                                                Method:<u></u><u></u></b></p>
                                    </td>
                                    <td  colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal">Credit
                                            Card<u></u><u></u></p>
                                    </td>
                                </tr>
{{--                                @if(!$sendAdmin && !empty($order->pwh_order_id))--}}
                                @if(false)
                                    <tr>
                                        <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                            <p class="MsoNormal"><b>Requisition Order:<u></u><u></u></b></p>
                                        </td>
                                        <td  colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                            <p class="MsoNormal"><a href="{{route('downloadRequisitionOrder',$order->pwh_order_id)}}">Download</a><u></u><u></u></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                            <p class="MsoNormal"><b>Order Link:<u></u><u></u></b></p>
                                        </td>
                                        <td  colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                            <p class="MsoNormal"><a href="{{$order->pwh_order_link}}">{{$order->pwh_order_link}}</a><u></u><u></u></p>
                                        </td>
                                    </tr>
                                @endif
                                <tr>

                                <tr>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal"><b>Total:<u></u><u></u></b></p>
                                    </td>
                                    <td colspan="2" style="border:solid #eeeeee 1.0pt;padding:4.5pt 4.5pt 4.5pt 4.5pt">
                                        <p class="MsoNormal">
                                            <span>{{ $currency}}</span><span>{{format_price($order->totalAmount)}}</span><u></u><u></u></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h2 style="margin-right:0in;margin-bottom:6.0pt;margin-left:0in;line-height:130%"><span style="font-size:13.5pt;line-height:130%;font-family:&quot;Helvetica&quot;,sans-serif;color:#557da1">Customer details</span></h2>
                        <p style="line-height:150%"><strong><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Arial&quot;,sans-serif;color:#737373">Email:</span></strong><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Arial&quot;,sans-serif;color:#737373">
                                                                                <a href="mailto:{{$order->email}}" target="_blank">{{$order->email}}</a></span></p>
                        <p style="line-height:150%"><strong><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Arial&quot;,sans-serif;color:#737373">Tel:</span></strong><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Arial&quot;,sans-serif;color:#737373">
                                                                                <a href="tel:{{$order->phone}}" value="+{{$order->phone}}" target="_blank">{{$order->phone}}</a></span></p>
                        <table  style="width:100.0%" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <td style="width:50.0%;padding:0in 0in 0in 0in" valign="top" width="50%">
                                    <h3 style="margin-right:0in;margin-bottom:6.0pt;margin-left:0in;line-height:130%"><span style="font-size:12.0pt;line-height:130%;font-family:&quot;Helvetica&quot;,sans-serif;color:#557da1">Billing address</span></h3>
                                    <p> {{$order->firstName.' '.$order->lastName}}<br>
                                        {{$order->address}}<br>
                                        {{$order->address2}}<br>
                                        {{$order->zip}}<br/>
                                        {{$order->city}}, {{$order->state}}, {{$order->country->name}} <br>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


