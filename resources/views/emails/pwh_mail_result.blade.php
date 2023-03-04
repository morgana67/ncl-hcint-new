<table>
    <tbody>
    <tr>
        <td colspan="2">
            <p>Hi {{$name}}!</p>
            @if(!$isDr)
                <p>Your Order Results are now {{$status}}.</p>
            @else
                <p>Order of the patient are now {{$status}}.</p>
            @endif

            <p>Click here to securely login and view them.</p>
            <p><a class="btn" style="border-radius: 4px; background-color: #39c; color: #fff; display: inline-block; padding: 5px 10px; text-decoration: none;" href="{{$url}}" target="_blank" rel="noopener">Click here</a></p>
        </td>
    </tr>
    <tr>
        <td>
            <p>Respectfully yours,<br />New Century Labs</p>
        </td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
