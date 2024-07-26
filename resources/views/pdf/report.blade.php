<x-layouts.pdf>

    <div class="mb-8">
        <h1 class="text-xl font-bold">Laporan Penjualan</h1>
        <p>{{ $subtitle }}</p>
    </div>

    <table class="table mb-8">
        <thead>
            @foreach ($cols as $col => $value)
                <th class="px-2" >{{ $col }}</th>
            @endforeach
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr>
                    @foreach ($cols as $value)
                        @switch($value)
                            @case('denda')
                                <td class="text-right">{{ number_format(data_get($record, $value)) }}</td>
                            @break

                            @case('total')
                                <td class="text-right">{{ number_format(data_get($record, $value)) }}</td>
                            @break

                            @case('lunas')
                                <td>{{ (bool) data_get($record, $value) ? 'Ya' : 'Tidak' }}</td>
                            @break

                            @default
                                <td>{{ data_get($record, $value) }}</td>
                        @endswitch
                    @endforeach
                </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($cols) }}" class="text-center">Tidak ada data yang ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot class="font-bold">
                <tr>
                    <td colspan="{{ count($cols) - 1 }}">Total Pendapatan</td>
                    <td>{{ number_format($total) }}</td>
                </tr>
            </tfoot>
        </table>
    </x-layouts.pdf>
