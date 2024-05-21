<x-layouts.pdf>

    <div class="mb-8">
        <h1 class="text-xl font-bold">Laporan Penjualan</h1>
        <p>Laporan ini dibuat dari {{ $from }} sampai {{ $until }}.
        </p>
    </div>

    <table class="table mb-8">
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
                    <td class="text-right">{{ number_format($item->total) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="font-bold">
            <tr>
                <td colspan="3">Total Pendapatan</td>
                <td>{{ number_format($total) }}</td>
            </tr>
        </tfoot>
    </table>
</x-layouts.pdf>
