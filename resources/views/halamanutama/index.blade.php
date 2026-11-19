@extends('layouts.master')

@section('title')
    Edit Halaman Utama
@endsection

@section('breadcrumb')
@parent
<li class="active"> Halaman Utama</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <form action="{{ route('halamanutama.update')}}" method="post" class="form-halamanutama" data-toggle="validator"
                enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> Perubahan berhasil disimpan
                    </div>
                    <div class="form-group row">
                        <label for="headline" class="col-lg-2 col-lg-offset-1 control-label">Headline</label>
                        <div class="col-lg-6">
                            <textarea name="headline" class="form-control" id="headline" autofocus></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                <div class="box-footer text-right">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@push('scripts')

<script>
    $(function () {
        showData();

        $('.form-halamanutama').on('submit', function (e) {
            e.preventDefault(); // Hindari reload halaman
            const form = this;

            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Data pengaturan akan diperbarui.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(form).attr('action'),
                        type: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        contentType: false
                    })
                    .done(response => {
                        showData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pengaturan berhasil diperbarui.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    })
                    .fail(errors => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Tidak dapat menyimpan data.'
                        });
                    });
                }
            });
        });
    });

    function showData() {
        $.get('{{ route('halamanutama.show') }}')
            .done(response => {
                $('[name=headline]').val(response.headline);
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
</script>

@endpush






