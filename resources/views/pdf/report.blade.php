<x-layouts.pdf>

    <h1>Laporan Bulanan</h1>
    <p>This PDF document is generated using domPDF in Laravel.</p>
    <table>
        <thead>
            <th>dibuat</th>
            <th>email</th>
            <th>instansi</th>
            <th>total</th>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->instansi }}</td>
                    <td>Rp. {{ number_format($item->total) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>Rp. 12.000</td>
            </tr>
        </tfoot>
    </table>
</x-layouts.pdf>
