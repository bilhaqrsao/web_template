<?php
 use Carbon\Carbon;
?>
<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-center">

        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a target="_blank" href="{{ route('public.index') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Dashboard
            </li>
        </ol>
        <!-- Breadcrumb end -->

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-newspaper fs-1 text-primary lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Artikel</h5>
                            <h3 class="m-0 text-primary">{{ $sumArticle }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Publikasi</h5>
                            <h3 class="m-0 text-primary">{{ $sumArticlePublished }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-file-earmark-text fs-1 text-secondary lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Halaman</h5>
                            <h3 class="m-0 text-secondary">{{ $sumPage }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Publikasi</h5>
                            <h3 class="m-0 text-secondary">{{ $sumPagePublished }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-megaphone fs-1 text-warning lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Pengumuman</h5>
                            <h3 class="m-0 text-warning">{{ $sumPengumuman }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Publikasi</h5>
                            <h3 class="m-0 text-warning">{{ $sumPengumumanPublished }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-check-circle fs-1 text-danger lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Berkas</h5>
                            <h3 class="m-0 text-danger">{{ $sumBerkas }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Download</h5>
                            <h3 class="m-0 text-danger">{{ $sumDownload }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-card-image fs-1 text-info lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Gallery</h5>
                            <h3 class="m-0 text-info">{{ $sumGallery }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Publikasi</h5>
                            <h3 class="m-0 text-info">{{ $sumGalleryPublished }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-play-btn fs-1 text-light lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Video</h5>
                            <h3 class="m-0 text-light">{{ $sumVideo }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Publikasi</h5>
                            <h3 class="m-0 text-light">{{ $sumVideoPublished }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-megaphone fs-1 text-warning lh-1"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="m-0 fw-normal">Total Banner</h5>
                            <h3 class="m-0 text-warning">{{ $sumBanner }}</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xxl-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <!-- Row start -->
                        <div class="row gx-3">
                            <div class="col-lg-5 col-sm-12 col-12">
                                <h6 class="text-center mb-3">Kegiatan Like Pengunjung</h6>
                                <div id="chartLike"></div>
                            </div>
                            <div class="col-lg-2 col-sm-12 col-12">
                                <div class="border rounded-4 px-2 py-4 h-100 text-center">
                                    <div class="mb-4">
                                        <h2 class="text-primary">{{ $sumLike }}</h2>
                                        <h6>Like</h6>
                                    </div>
                                    {{-- <div class="mb-4">
                                        <h2 class="text-danger">{{ $sumDislike }}</h2>
                                        <h6>Dislike</h6>
                                    </div> --}}
                                    <div class="mb-4">
                                        <h2 class="text-warning">{{ $sumShare }}</h2>
                                        <h6>Share</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-12 col-12">
                                <h6 class="text-center mb-3">Kegiatan Dislike Pengunjung</h6>
                                <div id="chartDisLike"></div>
                            </div>
                        </div>
                        <!-- Row ends -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xxl-8">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Pengunjung</h5>
                    </div>
                    <div class="card-body">
                        <!-- Row start -->
                        <div class="row gx-3">
                            <div class="col-lg-12 col-sm-12 col-12" style="min-height: 400px">
                                <h6 class="text-center mb-3">Chart Pengunjung</h6>
                                {{-- make filter week or mount with select --}}
                                <div class="d-flex justify-content-right">
                                    <select class="form-select w-auto" aria-label="Default select example" wire:change="$set('visitorRange', $event.target.value)">
                                        <option value="last_week" {{ $visitorRange == 'last_week' ? 'selected' : '' }}>Mingguan</option>
                                        <option value="last_month" {{ $visitorRange == 'last_month' ? 'selected' : '' }}>Bulanan</option>
                                    </select>
                                </div>
                                <div id="chartVisitor"></div>
                            </div>
                        </div>
                        <!-- Row ends -->
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Log Aktifitas</h5>
                    </div>
                    <div class="card-body">
                        <ul class="m-0 p-0" style="min-height: 480px; overflow: auto;">
                            @forelse ($logs as $log)
                            <li class="team-activity d-flex flex-wrap">
                                <div class="activity-time py-2 me-3">
                                    <p class="m-0">{{ Carbon::parse($log->created_at)->diffForHumans() }}</p>
                                    @if ($log->activity == 'Create')
                                    <span class="badge bg-primary">{{ $log->activity }}</span>
                                    @elseif ($log->activity == 'Update')
                                    <span class="badge bg-warning">{{ $log->activity }}</span>
                                    @elseif ($log->activity == 'Delete')
                                    <span class="badge bg-danger">{{ $log->activity }}</span>
                                    @elseif ($log->activity == 'Login')
                                    <span class="badge bg-success">{{ $log->activity }}</span>
                                    @elseif ($log->activity == 'Logout')
                                    <span class="badge bg-secondary">{{ $log->activity }}</span>
                                    @else
                                    <span class="badge bg-info">{{ $log->activity }}</span>
                                    @endif
                                </div>
                                <div class="d-flex flex-column py-2">
                                    <h6>{{ $log->User->name }}</h6>
                                    <p class="m-0">{{ $log->description }}</p>
                                </div>
                                @if ($log->activity == 'Create')
                                <div class="ms-auto mt-4">
                                    <i class="bi bi-plus-square fs-1 text-light lh-1"></i>
                                </div>
                                @elseif ($log->activity == 'Update')
                                <div class="ms-auto mt-4">
                                    <i class="bi bi-pencil-square fs-1 text-light lh-1"></i>
                                </div>
                                @elseif ($log->activity == 'Delete')
                                <div class="ms-auto mt-4">
                                    <i class="bi bi-trash fs-1 text-light lh-1"></i>
                                </div>
                                @elseif ($log->activity == 'Login')
                                <div class="ms-auto mt-4">
                                    <i class="bi bi-box-arrow-in-right fs-1 text-light lh-1"></i>
                                </div>
                                @elseif ($log->activity == 'Logout')
                                <div class="ms-auto mt-4">
                                    <i class="bi bi-box-arrow-right fs-1 text-light lh-1"></i>
                                </div>
                                @else
                                <div class="ms-auto mt-4">
                                    <i class="bi bi-info-square fs-1 text-light lh-1"></i>
                                </div>
                                @endif
                            </li>
                            @empty

                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

    </div>
    <!-- App body ends -->
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                height: 400,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [{
                name: 'Pengunjung',
                data: [
                    @foreach ($chartVisitor as $visit)
                        {{ $visit['visitor'] }},
                    @endforeach
                ]
            }],
            grid: {
                borderColor: '#e0e6ed',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 10,
                    left: 0
                },
            },
            xaxis: {
                categories: [
                    @foreach ($chartVisitor as $visit)
                        "{{ $visit['date'] }}",
                    @endforeach
                ],
                labels: {
                    style: {
                        colors: '#FFFFFF' // Set text color to white
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false,
                }
            },
            colors: ['#435EEF'],
            markers: {
                size: 0,
                opacity: 0.3,
                colors: ['#435EEF'],
                strokeColor: "#ffffff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#chartVisitor"),
            options
        );

        chart.render();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                height: 400,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [{
                name: 'Like',
                data: [
                    @foreach ($chartLike as $likes)
                        {{ $likes['like'] }},
                    @endforeach
                ]
            }],
            grid: {
                borderColor: '#e0e6ed',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 10,
                    left: 0
                },
            },
            xaxis: {
                categories: [
                    @foreach ($chartLike as $likes)
                        "{{ $likes['date'] }}",
                    @endforeach
                ],
                labels: {
                    style: {
                        colors: '#FFFFFF' // Set text color to white
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false,
                }
            },
            colors: ['#435EEF'],
            markers: {
                size: 0,
                opacity: 0.3,
                colors: ['#435EEF'],
                strokeColor: "#ffffff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#chartLike"),
            options
        );

        chart.render();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                height: 400,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [{
                name: 'Dislike',
                data: [
                    @foreach ($chartDislike as $dislikes)
                        {{ $dislikes['dislike'] }},
                    @endforeach
                ]
            }],
            grid: {
                borderColor: '#e0e6ed',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 10,
                    left: 0
                },
            },
            xaxis: {
                categories: [
                    @foreach ($chartDislike as $dislikes)
                        "{{ $dislikes['date'] }}",
                    @endforeach
                ],
                labels: {
                    style: {
                        colors: '#FFFFFF' // Set text color to white
                    }
                }
            },
            yaxis: {
                labels: {
                    show: false,
                }
            },
            colors: ['#435EEF'],
            markers: {
                size: 0,
                opacity: 0.3,
                colors: ['#435EEF'],
                strokeColor: "#ffffff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#chartDisLike"),
            options
        );

        chart.render();
    });
</script>
@endpush
