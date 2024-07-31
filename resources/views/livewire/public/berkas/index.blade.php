<div>
    {{-- Stop trying to control. --}}
    <div class="page-content project-list-page">
        <!-- HEADING PAGE-->
        <section class="heading-page heading-services-detail-1"
            style="background: url(&quot;{{ asset('assets/img/2.png') }}&quot;) center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="{{ route('public.index') }}">Home</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        <a href="#">Download</a>
                    </li>
                </ul>
                <div class="heading-title">
                    <h1>Daftar Berkas</h1>
                </div>
            </div>
        </section>
        <!-- END HEADING PAGE-->
        <!-- PROJECT LIST-->
        <section class="projects-layout">
            <div class="container">
                <!-- POST SERVICES DERAIL 1-->
                <section class="post-services post-services-detail-1">

                    <div class="post-paragraph p2">
                        <div class="post-heading">
                            <h3>Daftar File/Dokumen yang bisa didownload</h3>
                        </div>
                    </div>
                    <div class="post-table">
                        <table class="table table-bordered table-responsive">
                            <tbody>
                                @forelse ($datas as $data)
                               {{-- buat lebih rapi --}}
                                <tr>
                                    <td>
                                        {{ $data->title }}
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $data->file) }}" target="_blank">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </td>
                                    <td>
                                        {{-- jumlah download --}}
                                        <i class="fa fa-eye"></i> {{ $data->download }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Data tidak ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
                <!-- END POST SERVICES DERAIL 1-->
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
    @if ($datas->count() < 3)
        <style>
            footer {
                display: none;
            }
        </style>
    @endif
</div>
