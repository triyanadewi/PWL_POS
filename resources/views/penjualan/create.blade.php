@extends('layouts.template')

@section('content')
    <form id="form_transaksi" method="POST" action="{{ url('penjualan') }}">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">User</label>
                    <div class="col-11">
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">- Pilih User -</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Penjualan Kode</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
                            value="{{ $penjualan_kode }}" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Pembeli</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="pembeli" name="pembeli"
                            value="{{ old('pembeli') }}" required>
                        @error('pembeli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">
                        Total
                    </label>
                    <div class="col-3">
                        <input type="number" class="form-control" id="total" name="total" value="0" readonly>
                    </div>
                </div>
            </div>

            <hr>


                    <div class="" id="tambahBarang" tabindex="-1" aria-labelledby="tambahBarangLabel"
                        aria-hidden="true">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Daftar Barang yang tersedia</h3>    
                                    <table class="table table-bordered table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Kategori</th>
                                                <th class="text-center">Kode Barang</th>
                                                <th class="text-center">Nama Barang</th>
                                                <th class="text-center">Stok</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $idx = 1; ?>
                                            @foreach ($barang as $dt)
                                                <tr>
                                                    <td class="text-center">{{ $idx++ }}</td>
                                                    <td class="text-center">{{ $dt->kategori->kategori_nama }}</td>
                                                    <td class="text-center">{{ $dt->barang_kode }}</td>
                                                    <td class="text-center">{{ $dt->barang_nama }}</td>
                                                    <td class="text-center">{{ $dt->stok->stok_jumlah }}</td>
                                                    <td class="text-center">{{ $dt->harga_jual }}</td>
                                                    <td class="text-center">
                                                        <!-- <button type="button" data-toggle="modal" data-target="#stokModal{{ $dt->barang_id }}" class="btn btn-primary">Pilih</button> -->
                                                        <div class="btn btn-primary"
                                                            onclick="tambahKeranjang({{ $dt->barang_id }}, '{{ $dt->barang_nama }}', {{ $dt->harga_jual }}, 1, {{ $dt->stok->stok_jumlah }})">
                                                            Pilih</div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                        </div>
                                
                    </div>

                    <div class="card-body">
                        <h3 class="card-title mb-4">Daftar Barang yang dipilih</h3>
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table_barang">
                            </tbody>
                        </table>
                    <br>
                    <button id="simpanTransaksi" type="button" class="btn btn-primary btn-block" disabled>Simpan</button>
                    <a class="btn btn-default btn-block" href="{{ url('penjualan') }}">Kembali</a>
                    </div>
        </div>
    </form>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        let tableBarang = document.getElementById("table_barang");
        let items = [];

        function templateBaris(barangId, barangNama, harga, jumlah, stok) {
            return `
            <td class="text-center">${tableBarang.rows.length + 1}</td>
            <td class="text-center">${barangNama}</td>
            <td class="text-center">${harga}</td>
            <td class="text-center">
                <span>${jumlah}</span> 
            </td>
            <td class="text-center">
                <button class="btn btn-danger" onclick="hapusBarang(${barangId})">Hapus</button>
            </td>
            <input type="hidden" id="barang_id" name="barang_id[]" value="${barangId}">
            <input type="hidden" id="harga" name="harga[]" value="${harga}">
            <input type="hidden" id="jumlah" name="jumlah[]" value="${jumlah}">
        `;
        }

        function tambahKeranjang(barangId, barangNama, harga, jumlah, stok) {
            if (items.includes(barangId)) {
                let inputJumlah = tableBarang.querySelectorAll("input[name='jumlah[]']");
                let index = items.indexOf(barangId);
                let tr = tableBarang.querySelectorAll('tr')[index];
                let value = parseInt(inputJumlah[index].value) + 1;

                inputJumlah[index].value = value;
                let td = tr.querySelectorAll('td')[3]
                td.querySelector('span').innerText = value;
                updateTotal();
                return;
            }

            items.push(barangId);

            let barisBaru = document.createElement("tr");
            barisBaru.innerHTML = templateBaris(barangId, barangNama, harga, jumlah, stok);

            tableBarang.appendChild(barisBaru);
            updateTotal();

            // Aktifkan tombol "Simpan Transaksi"
            document.getElementById("simpanTransaksi").disabled = false;
        }

        function hapusBarang(barangId) {
            let index = items.indexOf(barangId);
            items.splice(index, 1);

            let tr = tableBarang.querySelectorAll('tr')[index];
            tr.remove();

            let trs = tableBarang.querySelectorAll('tr');
            trs.forEach((tr, idx) => {
                tr.querySelectorAll('td')[0].innerText = idx + 1;
            });
            updateTotal();
            
            // Nonaktifkan tombol "Simpan" jika tidak ada barang dalam keranjang
            if (trs.length === 0) {
                document.getElementById("simpanTransaksi").disabled = true;
            }
        }

        function updateTotal() {
            let total = 0;
            let harga = tableBarang.querySelectorAll("input[name='harga[]']");
            let jumlah = tableBarang.querySelectorAll("input[name='jumlah[]']");

            harga.forEach((item, index) => {
                total += parseInt(item.value) * parseInt(jumlah[index].value);
            });

            document.getElementById("total").value = total;
        }

        document.getElementById("simpanTransaksi").addEventListener("click", function(event) {
            event.preventDefault(); // Menghentikan perilaku default tombol submit

            // Disini Anda bisa menambahkan logika tambahan sebelum formulir disubmit, misalnya validasi

            // Submit formulir
            document.getElementById("form_transaksi").submit();
        });
    </script>
@endpush