<img class="logo" src="{{ 'img/app/logo_new.png' }}" style="display: block; margin: 0 auto 1em auto;max-width: 15%;"/>
<div style="max-width: 95%; margin: 0 auto;">
    <p style="font-size: 14px; color: #222; margin: 0 0 1em 0.5em;">{{ $title }}</p>
    <table width="100%" border="1px solid black" cellpadding="8px" cellspacing="0" style="border-collapse: collapse;color: #333;font-size: 13px;">
        <thead style="font-weight: bold;">
        <tr style="background: #ddd;">
            <td width="30%">{{ $thead1 }}</td>
            <td>{{ $thead2 }}</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row['col1'] }}</td>
                <td>{{ $row['col2'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p style="color: #777;font-size: 11px;float: right;">2016 © CROWDTICKET All Rights Reserved.</p>
</div>
