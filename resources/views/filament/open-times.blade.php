<table>
    @foreach ($times as $time)
        <tr>
            <td><strong>{{ number_format($time['MINUTES'] / 60, 0, ',', '.') }} Stunden</strong></td>
            <td>{{ $time['COMMENT'] }}</td>
        </tr>
    @endforeach

    @unless (!$times)
        Keine Daten vorhanden.
    @endunless
</table>
